<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        for ($k = 2; $k <= 12; $k++) {
            for ($i = 2; $i <= 18; $i++) {
                DB::table('seats')->insert([
                    'row' => $k,
                    'number' => $i,
                    'hall_id' => 1,
                ]);
            }
        }
    }
}
