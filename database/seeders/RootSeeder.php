<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
        ]);
    }
}
