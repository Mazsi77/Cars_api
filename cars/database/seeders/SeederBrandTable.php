<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederBrandTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => 'Volkswagen',
            'country' => 'Germany',
            'logo' => "https://www.carlogos.org/logo/Volkswagen-logo-2019-1500x1500.png"
        ]);

       
        DB::table('brands')->insert([
            'name' => 'BMW',
            'country' => 'Germany',
            'logo' => "https://www.carlogos.org/car-logos/bmw-logo-2020-blue-white.png"
        ]);

        DB::table('brands')->insert([
            'name' => 'Toyota',
            'country' => 'Japan',
            'logo' => "https://www.carlogos.org/car-logos/toyota-logo-2019-3700x1200.png"
        ]);
    }
}
