<?php

namespace Database\Seeders;

use App\User;
use Database\Seeders\AccountSeeder;
use Database\Seeders\GradesTableSeeder;
use Database\Seeders\LevelsTableSeeder;
use Database\Seeders\RoleTableSeeder;
use Database\Seeders\SettingsTableSeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // RoleTableSeeder::class,
            UserTableSeeder::class,
            CategorySeeder::class, // dev by Techlink360: Call the CategorySeeder
            ProductSeeder::class,

        ]);
    }
}
