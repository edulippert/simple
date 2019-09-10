<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,1)
            ->create([
                'email'=>'admin@user.com',
                'role_id' => 1,
                'id_number' => '123454',
                'cep' => '89806730',
                'address' => 'Rio de Janiero',
                'complement' => 2199,
                'phone_number' => '999433799',
                'is_active' => true
            ]);
    }
}
