<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => 'Catarinense',
        'cnpj' => $faker->phoneNumber,
        'address'=>$faker->address,
        'complement'=> '5454',
        'website'=> 'www.asd.com',
        'email'=> $faker->email,
        'phone_number'=> $faker->phoneNumber,
        'responsible'=> 'asd',
        'cep' => '898888'
    ];
});
