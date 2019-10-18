<?php

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
            PermissionsTableSeeder::class,
            UsersTableSeeder::class,
            CitiesTableSeeder::class,
            ModirKarevanTableSeeder::class,
            PersonsTableSeeder::class,
            TrafficsTableSeeder::class,
        ]);
    }
}
