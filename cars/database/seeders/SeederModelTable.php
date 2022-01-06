<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederModelTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('models')->insert([
            "brand_id" => 1,
            "model_name" => "Golf-4",
            "start_year" => 1998,
            "last_year" => 2005
        ]);

        DB::table('models')->insert([
            "brand_id" => 1,
            "model_name" => "Golf-5",
            "start_year" => 2005,
            "last_year" => 2008
        ]);

        DB::table('models')->insert([
            "brand_id" => 2,
            "model_name" => "Model 3",
            "start_year" => 1998,
            "last_year" => 2003
        ]);

        DB::table('models')->insert([
            "brand_id" => 2,
            "model_name" => "Model 3",
            "start_year" => 2003,
            "last_year" => 2006
        ]);

        DB::table('models')->insert([
            "brand_id" => 3,
            "model_name" => "Supra",
            "start_year" => 1997,
            "last_year" => 2001
        ]);
    }
}
