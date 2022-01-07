<?php

namespace App\Http\Controllers;

use App\Models\LikedBench;
use App\Models\ReportedBench;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BenchController extends Controller
{

    public function getReverseLocation($latitude, $longitude) {
        $item = Cache::get('rawLocation' . $latitude . $longitude);
        if(isset($item)) {
            echo $item;
            return;
        }
        $api_key = env('GEOKEO_API');
        $url = 'https://geokeo.com/geocode/v1/reverse.php?lat=' . $latitude . '&lng=' . $longitude . '&api=' . $api_key;
        $client = new Client();
        $res = $client->get($url);

        Cache::forever('rawLocation' . $latitude . $longitude, $res->getBody()->getContents());

        echo $res->getBody();
    }

    public function getReverseLocationAddress($latitude, $longitude) {
        $item = Cache::get('addressLocation' . $latitude . $longitude);
        $name = $subdistrict = $district = '';
        if(isset($item)) {
            if(isset($item['results'][0]['address_components']['name']))
                $name = $item['results'][0]['address_components']['name'];
            if(isset($item['results'][0]['address_components']['subdistrict']))
                $subdistrict = $item['results'][0]['address_components']['subdistrict'];
            if(isset($item['results'][0]['address_components']['district']))
                $district = $item['results'][0]['address_components']['district'];
            return $name . ' ' . $subdistrict . ', ' . $district;
        }
        $api_key = env('GEOKEO_API');
        $url = 'https://geokeo.com/geocode/v1/reverse.php?lat=' . $latitude . '&lng=' . $longitude . '&api=' . $api_key;
        $client = new Client();
        $res = $client->get($url);
        $json = json_decode($res->getBody(), JSON_PARTIAL_OUTPUT_ON_ERROR);
        Cache::forever('addressLocation' . $latitude . $longitude, $json);
        if(isset($json['results'][0]['address_components']['name']))
            $name = $json['results'][0]['address_components']['name'];
        if(isset($json['results'][0]['address_components']['subdistrict']))
            $subdistrict = $json['results'][0]['address_components']['subdistrict'];
        if(isset($json['results'][0]['address_components']['district']))
            $district = $json['results'][0]['address_components']['district'];
        return $name . ' ' . $subdistrict . ', ' . $district;
    }

    public function benchesInArea($latitude, $longitude) {
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
                                LIMIT 0 , 5"));
        return response()->json($benches, 200);
    }

    public function benchesGlobal($latitude, $longitude) {
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
                                ORDER BY distance"));
        return response()->json($benches, 200);
    }

    public function getBenchAtCoordinates($latitude, $longitude) {
        return DB::table('benches')->where('latitude', $latitude)->where('longitude', $longitude)->first();
    }

    public function report(Request $request, $id) {
        $reportedbench = ReportedBench::where('bench', $id)->where('reason', $request->radio);
        if(!$reportedbench->exists()) {
            ReportedBench::create([
                'bench' => $id,
                'reason' => $request->radio,
                'amount_reported' => 1,
            ]);
        }else {
            $reportedbench = $reportedbench->first();
            $reportedbench->amount_reported = $reportedbench->amount_reported + 1;
            $reportedbench->save();
        }
        return redirect(route('bench.details', $id))->with('alert', 'Bankje succesvol gerapporteerd!');
    }
}
