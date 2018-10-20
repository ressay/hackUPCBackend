<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function host()
    {
        return $this->hasOne('App\User','host_id');
    }

    public function type()
    {
        return $this->hasOne('App\User','type_id');
    }

    public function members()
    {
        return $this->belongsToMany('App\User','events_users');
    }
}
