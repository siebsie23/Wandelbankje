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

        foreach($benches['elements'] as $key => $value) {
            DB::table('benches')->insert([
                'latitude' => $value['lat'],
                'longitude' => $value['lon'],
            ]);
        }
    }
}
