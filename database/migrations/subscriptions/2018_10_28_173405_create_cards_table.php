<?php

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// class CreateCardsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('cards', function (Blueprint $table) {
//             $table->increments('id');
//             $table->unsignedInteger('user_id');
//             $table->string('token')->nullable();
//             $table->string('lastfour')->nullable();
//             $table->string('brand')->nullable();
//             $table->timestamps();
//             $table->foreign('user_id')->references('id')->on('users');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('cards');
//     }
// }
