<?php

namespace Database\Seeders;

use App\Models\Bench;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('report_reasons')->truncate(); // Clear data to avoid duplicates.
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        // Bankje bestaat niet
        DB::table('report_reasons')->insert([
            'reason' => 'Bankje bestaat niet'
        ]);
        // Bankje is stuk
        DB::table('report_reasons')->insert([
            'reason' => 'Bankje is stuk'
        ]);
        // Ongepaste foto
        DB::table('report_reasons')->insert([
            'reason' => 'Ongepaste of onjuiste foto'
        ]);
    }
}
