<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(RolePermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(WidgetsAreaSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(UsecasesSeeder::class);
        $this->call(PlansSeeder::class);
    }
}
