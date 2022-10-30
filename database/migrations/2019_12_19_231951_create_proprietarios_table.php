<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProprietariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('email',100);
            $table->string('celular',20);
            $table->string('fixo',20);
            $table->string('cpf',20);
            $table->string('cep',20);
            $table->string('rua',100);
            $table->string('numero',50);
            $table->string('complemento',50);
            $table->string('bairro',30);
            $table->string('cidade',30);
            $table->string('uf',2);
            $table->string('pais',30);
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
        Schema::dropIfExists('proprietarios');
    }
}
