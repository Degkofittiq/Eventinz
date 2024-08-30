<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'generic_id' => 'EVT-000001',
            'name' => 'Basit',
            'username' => '@BI',
            'email' => 'basitadmin@gmail.com',
            'password' => Hash::make('basitAdmin123@'),
            'is_otp_valid' => "yes",
            'role_id' => '4',
            'otp' => '879809',
        ]);
    }
}
