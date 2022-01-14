<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WeatherController extends Controller
{

    // all api list
    public $apiLinks = [
        [
            'id'          => '0', // test API Key: de7b23c3ab49d5c9a26a30c9c762e055
            'url'         => 'https://api.openweathermap.org/',
            'requestUrl'  => 'https://api.openweathermap.org/data/2.5/weather',
            'keyName'     => 'appid'
        ],
        [
            'id'          => '1', // test API Key: 989bc263ac0743b880680006221401
            'url'         => 'https://api.weatherapi.com/',
            'requestUrl'  => 'https://api.weatherapi.com/v1/current.json',
            'keyName'     => 'key'
        ]
    ];

    // link that will be used after construct function is done checking
    public $link = [];

    public function __construct() {
        // check if any api is down, if it is, use other one
        $this->availabityCheck();
    }
    
    public function requestWeatherData(Request $request) {

        // store received data from request
        $data = $request->all();

        // call api get request, provide all the stored data
        $query = $this->callApiGetRequest($this->link, $data['city'], $data['apiKey']);
        // set the received query results
        $result = $this->setResult($query);

        // return result to front end
        return response($result);

    }

    // method to set results for front end
    public function setResult($query) {
        // check which id is set currently
        switch($this->link['id']) {

            case 0: 
                // check if error message exists, if it does, set the return result as error message
                if(array_key_exists('message', $query)) {
                    $result = [
                        'message' => $query['message']
                    ];
                } else {
                // if error message doesn't exist, set the result for front end
                    $result = [
                        'name' => $query['name'],
                        'country' => $query['sys']['country'],
                        'temperature' => $this->calcTemperature($query['main']['temp']),
                        'feelsLike' => $this->calcTemperature($query['main']['feels_like']),
                        'wind' => $query['wind']['speed']
                    ];
                }

                return $result;

                break;

            case 1: 
                // check if error message exists, if it does, set the return result as error message
                if(array_key_exists('message', $query)) {
                    $result = [
                        'message' => $query['error']['message']
                    ];
                } else {
                // if error message doesn't exist, set the result for front end
                    $result = [
                        'name' => $query['location']['name'],
                        'country' => $query['location']['country'],
                        'temperature' => $query['current']['temp_c'],
                        'feelsLike' => $query['current']['feelslike_c'],
                        'wind' => $this->calcWind($query['current']['wind_kph'])
                    ];
                }

                return $result;

                break;

        }

    }

    public function calcTemperature($temp) {
        // calculate Kelvin to Celsius
        $calculation = $temp - 273.15;
        // round up the result
        $result = round($calculation);
        // return result
        return $result;
    }

    public function calcWind($wind) {
        // calculate wind kph to m/s
        $calculation = $wind / 3.6;
        // round up the result
        $result = round($calculation, 2);
        // return result
        return $result;
    }

    public function availabityCheck() {

        foreach ($this->apiLinks as $array) {

            if($this->checkApiAvailability($array['url'])) {
                // if website is found / available, set the current link array as current loop item
                $this->link = [ 
                    'id' => $array['id'],
                    'requestUrl' => $array['requestUrl'],
                    'keyName' => $array['keyName']  
                ];
                break;

            } else {
                // if website is down or not found, continue to go through list
                continue;
            }

        }

    }

    // method to check, if the api is available at the call time
    public function checkApiAvailability($link) {
    
        try {

            $client = new Client();
            // use get request to check if the link is available
            $client->get($link);
            // return true if it's found
            return true;

        } catch (GuzzleException $e) {
            // if the link is not available, return false
            if($e) {
                return false;
            }

        }

    }

    // method to call api
    public function callApiGetRequest($link, $city, $apiKey) {

        // make the call to given link, store data in response variable and format data to json
        $response = Http::get($link['requestUrl'], [
            'q' => $city,
            $link['keyName'] => $apiKey,
        ])->json();

        // return json data
        return $response;

    }

}
