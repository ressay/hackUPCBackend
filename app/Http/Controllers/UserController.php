<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function generateToken()
    {
        $user = new User([]);
        $user->save();
        return $user;
    }

    public function joinEvent()
    {
        if(isset($_GET))
        {
            $token = $_GET['token'];
            $event_id = $_GET['event_id'];
            $event = Event::find($event_id);
            $user = User::find($token);
            if(count($event->members) == $event->max_allowed)
                return 0;
            foreach ($event->members as $member) {
                if($member->id == $token)
                    return 0;
            }
            $event->members()->save($user);
            return 1;
        }
        else return 0;
    }



    static public function userClassificationArray($user)
    {
        $eventsAttended = $user->eventsJoined;
        $et = EventController::$EventsTypes;
        $typesSize = count($et);
        // typeOfEvent, day, distance
        $type = array_fill(0,$typesSize,0);
        $day = array_fill(0,7,0);
        $distance = array_fill(0,1,0);

        foreach ($eventsAttended as $event) {
            $type[$et[$event->type]]++;
            $day[date("N", strtotime($event->date_time))-1]++;
        }
        return array_merge($type,$day);
    }
}
