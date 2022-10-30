<?php

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// class CreatePaymentsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('payments', function (Blueprint $table) {
//             $table->increments('id');
//             $table->unsignedInteger('invoice_id');
//             $table->unsignedInteger('card_id');
//             $table->date('date');
//             $table->float('value',8,2);
//             $table->string('refnumber')->nullable();
//             $table->timestamps();
//             $table->foreign('invoice_id')->references('id')->on('invoices');
//             $table->foreign('card_id')->references('id')->on('cards');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('payments');
//     }
// }
