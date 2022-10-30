<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('email',100)->nullable();
            $table->string('celular',20)->nullable();
            $table->string('fixo',20)->nullable();
            $table->string('cpf',20)->nullable();
            $table->string('cep',9)->nullable();
            $table->string('rua',60)->nullable();
            $table->string('numero',30)->nullable();
            $table->string('complemento',30)->nullable();
            $table->string('bairro',30)->nullable();
            $table->string('cidade',30)->nullable();
            $table->string('uf',2)->default('RJ')->nullable();
            $table->string('pais',30)->default('Brasil')->nullable();

            $table->bigInteger('banco')->default('341')->nullable();
            $table->bigInteger('agencia')->default('0000')->nullable();
            $table->bigInteger('conta')->default('00000')->nullable();
            $table->bigInteger('digito')->default('00000')->nullable();
            $table->bigInteger('carteira')->default('00000')->nullable();
            $table->bigInteger('convenio')->default('0000000')->nullable();



            $table->string('db_host',30)->default('localhost')->nullable();
            $table->string('db_database',30)->nullable();
            $table->string('db_username',30)->default('root')->nullable();
            $table->string('db_password',30)->default('root')->nullable();
            
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
        Schema::dropIfExists('empresas');
    }
}
