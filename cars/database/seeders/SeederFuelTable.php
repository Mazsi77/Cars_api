<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederFuelTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuels')->insert([
            'name' => 'Diesel',
        ]);

        DB::table('fuels')->insert([
            'name' => 'Petrol',
        ]);

        DB::table('fuels')->insert([
            'name' => 'Electric',
        ]);
    }
}
