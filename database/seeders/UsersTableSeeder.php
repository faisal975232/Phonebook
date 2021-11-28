<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'fsl',
            'email' => 'fsl@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 2,
        ]);
    }
}
