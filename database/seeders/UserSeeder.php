<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            'name' => 'Eventinz Admin',
            'username' => '@EtzAdmin',
            'email' => 'eventinzadmin@gmail.com',
            'password' => Hash::make('eventinzAdmin@'),
            'is_otp_valid' => "yes",
            'role_id' => '4',
            'otp' => '100529',
            'created_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'generic_id' => 'EVT-000002',
            'name' => 'Basit',
            'username' => '@BI',
            'email' => 'basitadmin@gmail.com',
            'password' => Hash::make('basitAdmin123@'),
            'is_otp_valid' => "yes",
            'role_id' => '3',
            'otp' => '879809',
            'created_at' => Carbon::now(),
        ]);
    }
}
