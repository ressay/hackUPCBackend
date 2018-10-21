<?php

namespace App\Http\Controllers;

use App\Event;
use App\Place;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    public function getAllPlaces()
    {
        if(file_exists('places.txt')) {
            $text = file_get_contents('places.txt' );
            $places = json_decode($text);
            return $places;
        }
        $places = Place::all();
        date_default_timezone_set('Europe/Paris');
        foreach ($places as $place)
        {

            $token = $_GET['token'];
            $date = date("Y-m-d H:i:s");
            $next = null;
            $futureEvents = [];
            foreach ($place->events as $event) {
                $timestamp = strtotime($event->date_time);
                if($timestamp > strtotime($date)-$event->duration*60)
                {
                    $futureEvents[] = $event;
                    if($next == null)
                        $next = $event;
                }
            }


            if($next) {
                $next->currentTime = date("Y-m-d H:i:s");
                $next->date_time = strtotime($next->date_time);
                $next->membersCount = count($next->members);
                $joined = 0;
                foreach ($next->members as $user) {
                    if($token == $user->id)
                        $joined = 1;
                }
                $next->joined = $joined;
                unset($next->members);
            }
            $place->comming_next = $next;
            $place->types = explode(',',$place->types);
            $events = [];
            foreach($futureEvents as $event)
            {
                array_push($events,$event->id);
            }
            unset($place->events);
            $place->events = $events;
        }

        $settings = json_encode($places);
        file_put_contents( 'places.txt', $settings);
        return $places;
    }

    public function getEvents()
    {
        if(isset($_GET))
        {
            $id = $_GET['id'];
            $token = $_GET['token'];
            $place = Place::find($id);
            $futureEvents = [];
            $date = date("Y-m-d H:i:s");
            foreach ($place->events as $event) {
                $timestamp = strtotime($event->date_time);
                if($timestamp > strtotime($date)-$event->duration*60)
                {
                    $futureEvents[] = $event;
                }
            }
            $events = $futureEvents;
            foreach ($events as $event) {
                $joined = 0;
                foreach ($event->members as $user) {
                    if($token == $user->id)
                        $joined = 1;
                }
                $event->joined = $joined;
                $event->date_time = strtotime($event->date_time);
                $event->membersCount = count($event->members);
                unset($event->members);
            }
            return $events;
        }
        else
            return "Error GET not set";
    }

}
