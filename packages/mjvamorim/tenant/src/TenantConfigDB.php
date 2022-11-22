<?php

namespace Amorim\Tenant;

use Amorim\Tenant\Models\Empresa;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantConfigDB
{
    public static function createEmpresa(array $data)
    {
        $empresa = Empresa::create([
            'nome' => $data['name'],
            'email' => $data['email'],
            'celular' => $data['mobile'],
            'db_host' => Config::get('database.connections.main.host'),
            'db_username' => Config::get('database.connections.main.username'),
            'db_password' => Config::get('database.connections.main.password'),
        ]);
        $empresa->db_database = Config::get('database.connections.main.database').$empresa->id;
        $empresa->save();
        self::createDatabase($empresa);

        return $empresa;
    }

    public static function createDatabase(Empresa $empresa)
    {
        $sql = 'create database if not exists '.$empresa->db_database;
        DB::statement($sql);
    }

    public static function createTenantTables()
    {
        if (!Schema::connection('tenant')->hasTable('proprietarios')) {
            Schema::connection('tenant')->create('proprietarios', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 100)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('celular', 20)->nullable();
                $table->string('fixo', 20)->nullable();
                $table->string('cpf', 20)->nullable();
                $table->string('conjuge_nome', 100)->nullable();
                $table->string('conjuge_cpf', 20)->nullable();
                $table->string('cep', 9)->nullable();
                $table->string('rua', 60)->nullable();
                $table->string('numero', 30)->nullable();
                $table->string('complemento', 60)->nullable();
                $table->string('bairro', 30)->nullable();
                $table->string('cidade', 30)->nullable();
                $table->string('uf', 2)->nullable();
                $table->string('pais', 30)->nullable();
                $table->index('nome');
                $table->timestamps();
            });
        }
        if (!Schema::connection('tenant')->hasTable('unidades')) {
            Schema::connection('tenant')->create('unidades', function (Blueprint $table) {
                $table->increments('id');
                $table->string('descricao', 30);
                $table->float('adicional', 8, 2)->nullable()->default(0);
                $table->enum('tipo_adicional', ['Valor Fixo', 'Percentual'])->default('Valor Fixo');
                $table->unsignedInteger('proprietario_id');
                $table->longText('moradores')->nullable();
                $table->longText('veiculos')->nullable();
                $table->string('ramal', 30)->nullable();
                $table->longText('obs')->nullable();
                $table->enum('envio_boleto', ['Ambos', 'Impresso', 'Email'])->default('Ambos');
                $table->timestamps();
                $table->foreign('proprietario_id')->references('id')->on('proprietarios');
                $table->index('descricao');
            });
        }
        if (!Schema::connection('tenant')->hasTable('taxas')) {
            Schema::connection('tenant')->create('taxas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('anomes', 7);
                $table->date('dtvencto');
                $table->float('valor', 8, 2);
                $table->timestamps();
                $table->index('anomes');
            });
        }
        if (!Schema::connection('tenant')->hasTable('acordos')) {
            Schema::connection('tenant')->create('acordos', function (Blueprint $table) {
                $table->increments('id');
                $table->date('data');
                $table->unsignedInteger('unidade_id');
                $table->enum('situacao', ['Aberto', 'Quitado', 'Renegociado'])->default('Aberto');
                $table->longText('termos')->nullable();
                $table->timestamps();
                $table->foreign('unidade_id')->references('id')->on('unidades');
            });
        }
        if (!Schema::connection('tenant')->hasTable('debitos')) {
            Schema::connection('tenant')->create('debitos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('unidade_id');
                $table->enum('tipo', ['Mensalidade', 'Acordo', 'Avulso', 'Multa'])->default('Mensalidade');
                $table->longText('obs')->nullable();
                $table->unsignedInteger('taxa_id')->nullable();
                $table->unsignedInteger('acordo_id')->nullable();
                $table->date('dtvencto');
                $table->float('valor', 8, 2);
                $table->date('dtpagto')->nullable();
                $table->float('valorpago', 8, 2)->nullable();
                $table->enum('remessa', ['S', 'N'])->default('N');
                $table->unsignedInteger('boleto')->nullable()->unique();
                $table->unsignedInteger('acordo_quitacao_id')->nullable();
                $table->timestamps();

                $table->foreign('unidade_id')->references('id')->on('unidades');
                $table->foreign('taxa_id')->references('id')->on('taxas');
                $table->foreign('acordo_id')->references('id')->on('acordos');
                $table->foreign('acordo_quitacao_id')->references('id')->on('acordos');
            });
        }
        if (!Schema::connection('tenant')->hasTable('emails')) {
            Schema::connection('tenant')->create('emails', function (Blueprint $table) {
                $table->increments('id');
                $table->string('de', 100)->nullable();
                $table->string('para', 100)->nullable();
                $table->string('assunto', 100)->nullable();
                $table->longText('mensagem')->nullable();
                $table->string('anexo', 150)->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::connection('tenant')->hasTable('documentos')) {
            Schema::connection('tenant')->create('documentos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('unidade_id');
                $table->string('descricao', 100)->nullable();
                $table->string('arquivo', 100)->nullable();
                $table->timestamps();

                $table->foreign('unidade_id')->references('id')->on('unidades');
            });
        }
    }
}

// $table->increments('id');
// $table->unsignedInteger('user_id');
// $table->unsignedInteger('plan_id');
// $table->date('start_at');
// $table->date('end_at')->nullable();
// $table->integer('charge_day');
// $table->integer('trialdays')->default(0)->nullable();
// $table->enum('status', ['active', 'inactive', 'delayed', 'ontrial',])->default('inactive');
// $table->string('refnumber');
// $table->timestamps();
// $table->foreign('user_id')->references('id')->on('users');
// $table->foreign('plan_id')->references('id')->on('plans');
