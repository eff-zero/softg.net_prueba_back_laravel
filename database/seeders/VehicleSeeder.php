<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('vehicles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('vehicles')->insert([
            [
                'description' => 'Vehiculo 1',
                'year' => '2002',
                'mark' => 'Toyota',
                'capacity' => '2500',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'description' => 'Vehiculo 2',
                'year' => '2015',
                'mark' => 'Renault',
                'capacity' => '3000',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
