<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('routes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('routes')->insert([[
            'name' => 'Ruta del Sol',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti iusto laborum',
            'driver_id' => 2,
            'vehicle_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Ruta del Viento',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti iusto laborum',
            'driver_id' => 2,
            'vehicle_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]]);
    }
}
