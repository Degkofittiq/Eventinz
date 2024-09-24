<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RightsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rights_types')->insert([
            ['name' => 'Users Management','description' => 'Magement of users functionalities'],
            ['name' => 'Staff Management','description' => 'Management of Staff member'],
            ['name' => 'Events Management','description' => 'Magement of events'],
            ['name' => 'Vendors Categories Management','description' => 'Magement of Vendors Categories'],
            ['name' => 'Companies Management','description' => 'Management of Companies'],
            ['name' => 'Taxe Management','description' => 'Management of taxes'],
            ['name' => 'Vendors Classes Management','description' => 'Management of vendors Classes'],
            ['name' => 'Payments Management','description' => 'Management of payments'],
            ['name' => 'Subrcriptions plan Management','description' => 'Magement of subscriptions'],
            ['name' => 'Site Content Text Management','description' => 'Right for content Text Management'],
            ['name' => 'Site Content Images Management','description' => 'Right for content Images Management'],
            ['name' => 'Data limits','description' => 'Data limits'],
            ['name' => 'Support and Help','description' => 'Spport and Help'],
            // ...

        ]);
    }
}
