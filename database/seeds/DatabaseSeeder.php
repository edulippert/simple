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
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(FileTableSeeder::class);
        $this->call(CondominiumTableSeeder::class);
        $this->call(GuaranteeTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(ItemTableSeeder::class);
    }
}
