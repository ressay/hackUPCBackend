<?php

namespace App\Http\Controllers;

use App\Event;
use App\Place;
use DateTime;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function getAllPlaces()
    {
        $places = Place::all();
        foreach ($places as $place)
        {
            $token = $_GET['token'];
            $next = $place->events->where('date_time','>',now()->toDateTimeString())
                ->first();
            if($next) {
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
            foreach($place->events as $event)
            {
                array_push($events,$event->id);
            }
            unset($place->events);
            $place->events = $events;
        }

        return $places;
    }

    public function getEvents()
    {
        if(isset($_GET))
        {
            $id = $_GET['id'];
            $token = $_GET['token'];
            $place = Place::find($id);
            $events = $place->events;
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
