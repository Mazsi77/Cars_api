<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeederBrandTable::class);
        $this->call(SeederFuelTable::class);
        $this->call(SeederBodyTable::class);
        $this->call(SeederModelTable::class);
        $this->call(SeederFuelModelsTable::class);
        $this->call(SeederBodyModelTable::class);
    }
}
