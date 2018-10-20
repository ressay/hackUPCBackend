<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function events() // events posted
    {
        return $this->hasMany('App\Event','host_id');
    }

    public function eventsJoined()
    {
        return $this->belongsToMany('App\Event','events_users');
    }


}
