<?php

use App\Guarantee;
use Illuminate\Database\Seeder;

class GuaranteeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guarantee::create([
            'name' => 'Garantias Condominios Prediais',
            'description' => 'Sistemas, elementos, componentes e instalacoes'
        ]);

        Guarantee::create([
            'name' => 'Garantias Casas 2 Quartos',
            'description' => 'Inclui garantias padroes utilizadas em casas de 2 quartos'
        ]);
    }
}
