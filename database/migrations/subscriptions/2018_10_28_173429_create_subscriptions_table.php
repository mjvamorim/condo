<?php

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// class CreateSubscriptionsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('subscriptions', function (Blueprint $table) {
//             $table->increments('id');
//             $table->unsignedInteger('user_id');
//             $table->unsignedInteger('plan_id');
//             $table->date('start_at');
//             $table->date('end_at')->nullable();
//             $table->integer('charge_day');
//             $table->integer('trialdays')->default(0)->nullable();
//             $table->enum('status', ['active', 'inactive', 'delayed', 'ontrial',])->default('inactive');
//             $table->string('refnumber');
//             $table->timestamps();
//             $table->foreign('user_id')->references('id')->on('users');
//             $table->foreign('plan_id')->references('id')->on('plans');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('subscriptions');
//     }
// }
