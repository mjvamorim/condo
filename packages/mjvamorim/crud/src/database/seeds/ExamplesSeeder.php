<?php

namespace Amorim\Crud\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Amorim\Crud\Models\Example;


class ExamplesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1,2000) as $index) {
            Example::insert([
                'name'        => $faker->name,
                'email'       => $faker->freeEmail,
                'mobile'      => $faker->e164PhoneNumber,
                'phone'       => $faker->e164PhoneNumber,
                'postal_code' => $faker->postcode,
                'street'      => $faker->streetAddress,
                'number'      => $faker->buildingNumber,
                'district'    => $faker->cityPrefix,
                'city'        => $faker->city,
                'state'       => $faker->stateAbbr,
            ]);
        }
    }
}