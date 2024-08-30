<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            ['name' => 'Host','description' => 'Simple Client'],
            ['name' => 'Vendor','description' => 'Client Service Provider'],
            ['name' => 'Admin','description' => 'Admin of Clients'],
            ['name' => 'Master Admin','description' => 'Admin for all Plateform'],
        ]);
    }
}
