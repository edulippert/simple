<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'description' => 'Hidrossanitario',
            'is_guarantee' => false
        ]);

        Group::create([
            'description' => 'Instalacoes Hidraulicas',
            'is_guarantee' => true
        ]);
    }
}
