<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rights')->insert([
            [
                'rights_types_id' => '1',
                'name' => 'print_list',
                'description' => 'print any list'
            ],
            [
                'rights_types_id' => '1',
                'name' => 'view',
                'description' => 'view any list'
            ],
            [
                'rights_types_id' => '1',
                'name' => 'edit',
                'description' => 'edit user profiles'
            ],
            [
                'rights_types_id' => '1',
                'name' => 'delete',
                'description' => 'delete user'
            ]
        ]);
    }
}
