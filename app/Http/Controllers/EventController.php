<?php

namespace App\Http\Controllers;
include 'KMeans/Space.php';
include "KMeans/Point.php";
include 'KMeans/Cluster.php';

use App\Event;
use App\User;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use KMeans\Space;



class EventController extends Controller
{
    static $EventsTypes = ['volleyball' => 0,
        'table tennis' => 1,
        'tennis' => 2,
        'football' => 3,
        'basketball' => 4,
        'frisbee' => 5];
    public function getAllEvents()
    {
        $events = Event::all();
        foreach ($events as $event) {
            $event->date_time = strtotime($event->date_time);
            $event->membersCount = count($event->members);
            unset($event->members);
        }
        return $events;
    }

    public function hostEvent()
    {
        $arr = Input::all();
        $id_host = $arr['token'];
        $event = new Event();
        $event->date_time = date('Y-m-d H:i:s',$arr['date_time']);
        $event->max_allowed = $arr['max_allowed'];
        $event->duration = $arr['duration'];
        $event->description = $arr['description'];
        $event->host_id = $id_host;
        $event->place_id = $arr['place_id'];
        $event->type = $arr['type'];
        $event->name = $arr['name'];
        $event->save();
        $user = User::find($id_host);
        $event->members()->save($user);

//        echo now()->timestamp;
    }

    public function getRecommendation()
    {
        $users = User::all();
        $toRecom = User::find($_GET['token']);


        $points = [];
        $ids = [];
        foreach ($users as $user) {
            $points[] = UserController::userClassificationArray($user);
            $ids[] = $user->id;
            var_dump($points[count($points)-1]);
            echo '<BR>';
        }

//        $space = new Space(count($points[0]));
//        foreach ($points as $i => $point) {
//            $space->addPoint($point,$ids[$i]);
//        }
//        $clusters = $space->solve(10,Space::SEED_DEFAULT);
//        $recomCluster = null;
//        foreach ($clusters as $i => $cluster)
//        {
//            foreach ($cluster as $point) {
//                if($space[$point] == $toRecom->id) {
//                    $recomCluster = $cluster;
//                    break;
//                }
//            }
//            if($recomCluster != null)
//                break;
//        }
//        foreach ($recomCluster as $point) {
//            $us = User::find($space[$point]);
//            var_dump(UserController::userClassificationArray($us));
//            echo "<BR>";
//        }
//            printf("Cluster %s [%d,%d]: %d points\n", $i, $cluster[0], $cluster[1], count($cluster));


//        return $users[0]->eventsJoined;
    }

}
