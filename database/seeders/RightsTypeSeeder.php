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
            ['name' => 'Listing','description' => 'All listing right'],
            ['name' => 'User Management','description' => 'Magement of users functionalities right'],
            ['name' => 'Staff Management','description' => 'Management of Staff member right'],
            ['name' => 'Event Management','description' => 'Magement of events right'],
            ['name' => 'Taxe Management','description' => 'Management of taxes right'],
            ['name' => 'Vendors Categories Management','description' => 'Management of category right'],
            ['name' => 'Payments Management','description' => 'Management of payments right'],
            ['name' => 'Subrcriptions plan Management','description' => 'Magement of subscriptions right'],
            ['name' => 'Site Content Text Management','description' => 'Right for content Text Management'],
            ['name' => 'Spport and Help','description' => 'Spport and Help'],
            // ...

        ]);
    }
}
