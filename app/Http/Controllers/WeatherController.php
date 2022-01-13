<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    
    public function requestWeatherData(Request $request) {

        // receive data, provide api link
        $data = $request->all();
        $link = 'https://api.openweathermap.org/data/2.5/weather';

        // call api get request, provide all the received data from above
        $result = $this->callApiGetRequest($link, $data['city'], $data['apiKey']);

        // return result to front end
        return response($result);

    }

    public function test() {


       
    }

    // method to call api
    public function callApiGetRequest($link, $city, $apiKey) {

        // format the response, include link, city, api key, convert it to json data format
        $response = Http::get($link, [
            'q' => $city,
            'appid' => $apiKey,
        ])->json();
        
        // return json data
        return $response;

    }

    // test API Key: de7b23c3ab49d5c9a26a30c9c762e055

}
