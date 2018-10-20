<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EventController extends Controller
{
    public function getAllEvents()
    {
        return Event::all();
    }

    public function hostEvent()
    {
//        if(isset($_GET))
//        {
//            $token = $_GET['token'];
//            $event_atts = Input::all();
//            echo $event_atts['name'];
//        }
        $arr = Input::all();
        $id_host = $arr['token'];
        $event = new Event();
        $event->date_time = $arr['date_time'];
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

//        echo "something";
    }


}
