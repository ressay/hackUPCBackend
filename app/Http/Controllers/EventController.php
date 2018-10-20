<?php

namespace App\Http\Controllers;

use App\Event;
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
        echo Input::all();
    }

    public function tryHost()
    {
        $client = new Client();

            $url = "http://localhost:8000/api/hostEvent?token=2";

        $myBody['name'] = "Demo";

        $request = $client->post($url);

        $response = $request->send();
    }

}
