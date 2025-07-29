<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DemoUsersSeeder::class, // Demo users dengan nama campuran
            TaskSeeder::class,
        ]);
    }
}