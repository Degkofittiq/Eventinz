<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VarriablesLimitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('varriables_limits')->insert([
            ['name' => 'tagline','value' => null],
            ['name' => 'images','value' => null]
        ]);
    }
}
