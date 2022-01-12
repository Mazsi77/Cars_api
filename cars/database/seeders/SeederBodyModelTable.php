<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederBodyModelTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('body_type_model')->insert([
            "model_id" => 1,
            "body_type_id" => 1,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 1,
            "body_type_id" => 2,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 2,
            "body_type_id" => 1,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 2,
            "body_type_id" => 2,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 3,
            "body_type_id" => 2,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 3,
            "body_type_id" => 3,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 4,
            "body_type_id" => 4,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 4,
            "body_type_id" => 2,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 4,
            "body_type_id" => 3,
        ]);
        DB::table('body_type_model')->insert([
            "model_id" => 5,
            "body_type_id" => 4,
        ]);
    }
}
