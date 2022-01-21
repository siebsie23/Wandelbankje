<?php

namespace App\Http\Controllers;

use App\Models\Bench;
use App\Models\LikedBench;
use App\Models\Photo;
use App\Models\ReportedBench;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Image;

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
                                WHERE is_new = 0
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
                                WHERE is_new = 0
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

    public function add_bench(Request $request) {
        $bench = Bench::create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'added_by' => Auth::id(),
        ]);

        // Image processing
        if(isset($request->image)) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg|max:15000',
            ]);

            $imageName = time() . '.' . $request->image->extension();

            // Add watermark
            $img = \Intervention\Image\Facades\Image::make($request->image);
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->insert(public_path('images/watermark.png'), 'bottom-right', 10, 10);
            $img->save(public_path('images/benches/' . $imageName));

            $save = new Photo;
            $save->bench = $bench->id;
            $save->path = $imageName;
            $save->added_by = Auth::id();
            $save->save();
        }
        return redirect(route('welcome'))->with('alert', 'Bankje succesvol toegevoegd!');
    }

    public function add_photo(Request $request) {
        // Image processing
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg|max:15000',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        // Add watermark
        $img = \Intervention\Image\Facades\Image::make($request->image);
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->insert(public_path('images/watermark.png'), 'bottom-right', 10, 10);
        $img->save(public_path('images/benches/' . $imageName));

        $save = new Photo;
        $save->bench = $request->bench;
        $save->path = $imageName;
        $save->added_by = Auth::id();
        $save->save();
        return redirect(route('bench.details', $request->bench))->with('alert', 'Foto succesvol ingezonden!');
    }

    public function delete_bench($user_id, $bench_id) {
        $bench = Bench::find($bench_id);
        if($bench->added_by == $user_id) {
            $bench->delete();
        }else {
            return redirect(route('dashboard'))->with('alert', 'Kon bankje niet verwijderen!');
        }
        return redirect(route('dashboard'))->with('alert', 'Bankje verwijderd!');
    }

}
