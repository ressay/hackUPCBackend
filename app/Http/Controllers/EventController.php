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
        $points = [];
        for ($i=0; $i < $n = 100; $i++) {
            $points[] = [mt_rand(0, 100), mt_rand(0, 100)];
        }

        $space = new Space(2);

        foreach ($points as $i => $coordinates) {
            $space->addPoint($coordinates);
//            printf("\r%.2f%%", ($i / $n) * 100);
        }
        $clusters = $space->solve(3,Space::SEED_DEFAULT);

        foreach ($clusters as $i => $cluster)
            printf("Cluster %s [%d,%d]: %d points\n", $i, $cluster[0], $cluster[1], count($cluster));
    }

}
