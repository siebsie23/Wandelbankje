<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BenchController extends Controller
{

    public function getReverseLocation($latitude, $longitude) {
        $item = Cache::get('rawLocation' . $latitude . $longitude);
        if(isset($item)) {
            echo $item->getBody();
            return;
        }
        $api_key = env('GEOKEO_API');
        $url = 'https://geokeo.com/geocode/v1/reverse.php?lat=' . $latitude . '&lng=' . $longitude . '&api=' . $api_key;
        $client = new Client();
        $res = $client->get($url);

        Cache::forever('rawLocation' . $latitude . $longitude, $res);

        echo $res->getBody();
    }

    public function getReverseLocationAddress($latitude, $longitude) {
        $item = Cache::get('addressLocation' . $latitude . $longitude);
        if(isset($item))
            return $item['results'][0]['address_components']['name'] . ' ' . $item['results'][0]['address_components']['subdistrict'] . ', ' . $item['results'][0]['address_components']['district'];
        $api_key = env('GEOKEO_API');
        $url = 'https://geokeo.com/geocode/v1/reverse.php?lat=' . $latitude . '&lng=' . $longitude . '&api=' . $api_key;
        $client = new Client();
        $res = $client->get($url);
        $json = json_decode($res->getBody(), JSON_PARTIAL_OUTPUT_ON_ERROR);
        Cache::put('addressLocation' . $latitude . $longitude, $json);
        return $json['results'][0]['address_components']['name'] . ' ' . $json['results'][0]['address_components']['subdistrict'] . ', ' . $json['results'][0]['address_components']['district'];
    }

    public function benchesInArea($latitude, $longitude, $amount = 5, $json = true) {
        $benches = DB::select(DB::raw("SELECT
                                    id, latitude, longitude, (
                                      6371 * acos (
                                      cos ( radians($latitude) )
                                      * cos( radians( latitude ) )
                                      * cos( radians( longitude ) - radians($longitude) )
                                      + sin ( radians($latitude) )
                                      * sin( radians( latitude ) )
                                    )
                                ) AS distance
                                FROM benches
                                HAVING distance < 5
                                ORDER BY distance
                                LIMIT 0 , $amount"));
        if($json)
            return response()->json($benches, 200);
        else
            return $benches;
    }

    public function getBenchAtCoordinates($latitude, $longitude) {
        return DB::table('benches')->where('latitude', $latitude)->where('longitude', $longitude)->first();
    }
}
