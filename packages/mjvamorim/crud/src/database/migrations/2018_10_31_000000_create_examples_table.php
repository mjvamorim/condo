<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $database = config('tenant.connections.tenant.database');
        $sql = 'create database if not exists '.$database;
        DB::statement($sql);
        Schema::dropIfExists($database.'.examples');
        Schema::create($database.'.examples', 
          function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            //Contacts
            $table->string('email',100)->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('phone',20)->nullable();
            //Address
            $table->string('postal_code',20)->nullable();
            $table->string('street',50)->nullable();
            $table->string('number',20)->nullable();
            $table->string('complement',50)->nullable();
            $table->string('district',30)->nullable();
            $table->string('city',30)->nullable();
            $table->string('state',2)->default('RJ')->nullable();
            $table->string('country',30)->default('Brasil')->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $database = config('tenant.connections.tenant.database');
        Schema::dropIfExists($database.'.examples');
    }
}
