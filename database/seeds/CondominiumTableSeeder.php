<?php

use App\Condominium;
use Illuminate\Database\Seeder;

class CondominiumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condominium::create([
            'company_id' => 1,
            'file_id' => 1,
            'name' => 'Dona Geni',
            'id_number' => '2199',
            'address' => 'Rio de Janeiro',
            'complement' => 'empty',
            'zipcode' => '89806-730',
            'licence_due_date' => '2019-09-09',
            'is_active' => true,

        ]);

        Condominium::create([
            'file_id' => 1,
            'name' => 'Edificio Europa',
            'id_number' => '2166',
            'address' => 'Rua Tavares',
            'complement' => 'empty',
            'zipcode' => '89806-730',
            'licence_due_date' => '2019-09-09',
            'is_active' => true,

        ]);
    }
}
