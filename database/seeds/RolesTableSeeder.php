<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'description' => 'Admin'
        ]);
        Role::create([
            'description' => 'Company'
        ]);
        Role::create([
            'description' => 'User'
        ]);
    }
}
