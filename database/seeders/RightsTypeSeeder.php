<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
        // Path to the SQL file
        $path = database_path('seeders/rights_types.sql'); 

        // Read the contents of the SQL file
        $sql = File::get($path);

        // Execute the SQL commands
        DB::unprepared($sql);

        $this->command->info('Database seeded with rights_types.sql');
    }
}
