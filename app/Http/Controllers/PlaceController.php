<?php

namespace App\Http\Controllers;

use App\Event;
use App\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function getAllPlaces()
    {
        $places = Place::all();
        foreach ($places as $place)
        {
            $place->comming_next = $place->events->where('date_time','>',now()->toDateTimeString())
                ->first();
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
                unset($event->members);
            }
            return $events;
        }
        else
            return "Error GET not set";
    }
}
