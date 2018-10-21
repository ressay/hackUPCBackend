<?php

namespace App\Http\Controllers;

use App\Event;
use App\Place;
use App\User;
use Illuminate\Http\Request;

class DataBaseFiller extends Controller
{
    public function createRandomUsers()
    {
        for($i=0;$i<100;$i++)
        {
            $user = new User([]);
            $user->save();
        }
    }

    public function createRandomEvents()
    {
        $places = Place::all();
        $users = User::all();
        foreach ($places as $place) {
            for($i=0;$i<mt_rand(5,15);$i++)
            {
                $id_host = $users[mt_rand(0, count($users)-1)]->id;
                $event = new Event();
                $event->date_time = date('Y-m-d H:i:s',
                    strtotime(Date('Y-m-d H:i:s'))+mt_rand(-1440*60*30,1440*60*7));
                $event->max_allowed = mt_rand(2,30);
                $event->duration = mt_rand(10,240);
                $event->description = "descriptiooon";
                $event->host_id = $id_host;
                $event->place_id = $place->id;
                $types = explode(',',$place->types);
                $event->type = $types[mt_rand(0,count($types)-1)];
                $event->name = "naaaame";
                $event->save();
                $user = User::find($id_host);
                $event->members()->save($user);
            }
        }
    }

    public function randomJoin()
    {
        $events = Event::all();
        $users = User::all();
        foreach ($events as $event) {
            $members = $event->members;
            if(count($members) >= $event->max_allowed)
                continue;
            $toJoin = mt_rand(0,$event->max_allowed - count($members));
            foreach ($users as $i => $user) {
                $in = false;
                foreach ($members as $member) {
                    if($member->id == $user->id)
                    {
                        $in = true;
                        break;
                    }
                }
                if($in)
                    continue;
                $left = count($users) - $i;
                $r = mt_rand(1,$left);
                if($r <= $toJoin )
                {
                    $event->members()->save($user);
                    $toJoin--;
                }
            }
        }
    }
}
