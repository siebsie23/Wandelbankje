<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BenchController extends Controller
{
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
}
