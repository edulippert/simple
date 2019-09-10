<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'group_id' => 1,
            'description' => 'Agua Potavel - Reservatorios'
        ]);

        Item::create([
            'group_id' => 2,
            'description' => 'Colunas de Agua Fria'
        ]);
    }
}
