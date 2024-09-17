<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RightsTypeSeeder;
use Database\Seeders\RightsTableSeeder;
use Database\Seeders\contentTextManagementSeeder;
use Database\Seeders\contentImagesManagementSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            // Eventinz Seeders
            RoleSeeder::class,
            UserSeeder::class,
            contentTextManagementSeeder::class,
            contentImagesManagementSeeder::class,
            RightsTableSeeder::class, 
            RightsTypeSeeder::class,
        ]);
    }
}
