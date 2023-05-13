<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            [
                'first_name' => 'Jesús',
                'last_name' => 'Hernández',
                'email' => 'jesus@correo.com',
                'password' => Hash::make('12345678'),
                'dob' => '1997-09-18',
                'address' => 'Calle 99 #99-99',
                'city' => 'Barranquilla',
                'zip' => '000000',
                'phone' => '3000000000',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
