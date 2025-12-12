<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'first_name' => 'Rima',
            'last_name' => 'Girnius',
            'email' => 'rimagirnius@gmail.com',
            'phone' => '0223232323',
            'password' => Hash::make('password'),
            'role' => 'admin',


        ]);
    }
}
