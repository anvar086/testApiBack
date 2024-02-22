<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private string $url = 'http://dataservice.accuweather.com/locations/v1/cities/search';
    public function weather(Request $request){
        if ($request->type=="accweather") {
            if ($request->city == !null) {
                $full_url = Http::get($this->url . "?apikey=" . env('API_KEY_ACC') . "&q=" . $request->city);
                $a = json_decode($full_url);
                $key = $a[0]->Key;
                if ($key == !null) {
                    $url1 = Http::get('http://dataservice.accuweather.com/forecasts/v1/daily/1day/'
                        . $key . "?apikey=" . env('API_KEY_ACC'));
                    $b = json_decode($url1);
                    return $b;
                }
            }
            return "null";
        }
        if ($request->type=="openweather"){
            if ($request->city == !null) {
                $url_open = Http::get('http://api.openweathermap.org/geo/1.0/direct'
                    ."?q=".$request->city."&appid=".env('API_KEY_OPEN'));
                $a = json_decode($url_open);
                $lat = $a[0]->lat;
                $lon = $a[0]->lon;
                if ($lat ==! null && $lon ==! null ) {
                    $url_weather = Http::get('https://api.openweathermap.org/data/2.5/weather?lat='
                        .$lat.'&lon='.$lon."&appid=".env('API_KEY_OPEN'));
                    $c = json_decode($url_weather);
                    return $c;
                }
            }
            return "null";
        }
        return "null";

    }
}
