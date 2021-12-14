<?php

namespace Database\Seeders;

use App\Models\Bench;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BenchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bench::truncate();

        $json = File::get('database/data/bankjes.json');
        $benches = json_decode($json, true);

        $insert_data = [];

        foreach($benches['elements'] as $key => $value) {
            if(!isset($value['lat']) || !isset($value['lon']))
                continue;
            $data = [
                'latitude' => $value['lat'],
                'longitude' => $value['lon'],
            ];

            $insert_data[] = $data;
        }

        $insert_data = collect($insert_data);

        $chunks = $insert_data->chunk(5000);

        foreach($chunks as $chunk) {
            DB::table('benches')->insert($chunk->toArray());
        }
    }
}
