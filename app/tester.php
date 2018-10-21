<?php
/**
 * Created by PhpStorm.
 * User: ressay
 * Date: 20/10/18
 * Time: 14:49
 */
use GuzzleHttp\Client;




$data = array(
    'name'      => 'event again',
    'date_time'    => '1540091677',
    'max_allowed'       => '12',
    'duration' => '60',
    'description'      => 'you are gonna do well',
    'type' => 'football',
    'place_id' => '2',
    'token' => '1'
);
//
$options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => json_encode( $data ),
        'header'=>  "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n"
    )
);
$url='http://localhost:8000/api/hostEvent';
$json = json_encode($data);
$context  = stream_context_create( $options );
$result = file_get_contents( $url, false, $context );
echo $result;

//API Url
//$url = 'http://example.com/api/JSON/create';

//Initiate cURL.
//$ch = curl_init($url);
//
////The JSON data.
////$jsonData = array(
////    'username' => 'MyUsername',
////    'password' => 'MyPassword'
////);
//
////Encode the array into JSON.
//$jsonDataEncoded = json_encode($jsonData);
//
////Tell cURL that we want to send a POST request.
//curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//
////Set the content type to application/json
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request
//$result = curl_exec($ch);
//
//echo $result;
