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
        $this->call(Amorim\Tenant\Database\Seeds\TenantSeeder::class);
        //$this->call(Amorim\Crud\Database\Seeds\ExamplesSeeder::class);
        

    }
}


