<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederBodyTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('body_types')->insert([
            'name' => 'Hatchback',
            'seat_number' => 5
        ]);

        DB::table('body_types')->insert([
            'name' => 'Wagon',
            'seat_number' => 5
        ]);

        DB::table('body_types')->insert([
            'name' => 'Sedan',
            'seat_number' => 5
        ]);

        DB::table('body_types')->insert([
            'name' => 'Coupe',
            'seat_number' => 2
        ]);
    }
}
