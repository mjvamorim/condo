<?php

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// class CreateInvoicesTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('invoices', function (Blueprint $table) {
//             $table->increments('id');
//             $table->unsignedInteger('subscription_id');
//             $table->date('date');
//             $table->date('value');
//             $table->string('refnumber')->nullable();
//             $table->enum('status', ['paid', 'unpaid', 'canceld',])->nullable()->default('unpaid');
//             $table->timestamps();
//             $table->foreign('subscription_id')->references('id')->on('subscriptions');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('invoice');
//     }
// }
