<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'refnumber')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('refnumber')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'refnumber')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('refnumber');
            });
        }
    }
}