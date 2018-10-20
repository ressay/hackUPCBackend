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
            $event->members()->save($user);
            return 1;
        }
        else return 0;
    }
}
