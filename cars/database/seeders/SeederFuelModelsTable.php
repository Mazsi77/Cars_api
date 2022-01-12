<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederFuelModelsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuel_model')->insert([
            "model_id" => 1,
            "fuel_id" =>1
        ]);

        DB::table('fuel_model')->insert([
            "model_id" => 1,
            "fuel_id" =>2
        ]);

        DB::table('fuel_model')->insert([
            "model_id" => 2,
            "fuel_id" =>1
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 2,
            "fuel_id" =>2
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 3,
            "fuel_id" =>1
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 3,
            "fuel_id" =>3
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 4,
            "fuel_id" =>1
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 4,
            "fuel_id" =>2
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 4,
            "fuel_id" =>3
        ]);
        DB::table('fuel_model')->insert([
            "model_id" => 5,
            "fuel_id" =>1
        ]);
    }

}
