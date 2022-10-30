<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Estado;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('estados');
        Schema::create('estados', function (Blueprint $table) {
            $table->string('uf',2);
            $table->string('estado',30);      
            $table->timestamps();
            $table->primary('uf');
        });
        Estado::create(['uf'=>'RJ', 'estado' => 'Rio de Janeiro', ]);
        Estado::create(['uf'=>'SP', 'estado' => 'São Paulo', ]);
        Estado::create(['uf'=>'MG', 'estado' => 'Minas Gerais', ]);
        Estado::create(['uf'=>'ES', 'estado' => 'Espírito Santo', ]);

        Estado::create(['uf'=>'RS', 'estado' => 'Rio Grande do Sul', ]);
        Estado::create(['uf'=>'SC', 'estado' => 'Santa Catarina', ]);
        Estado::create(['uf'=>'PR', 'estado' => 'Paraná', ]);

        Estado::create(['uf'=>'MT', 'estado' => 'Mato Grosso', ]);
        Estado::create(['uf'=>'MS', 'estado' => 'Mato Grosso do Sul', ]);
        Estado::create(['uf'=>'GO', 'estado' => 'Goiás', ]);
        Estado::create(['uf'=>'DF', 'estado' => 'Distrito Federal', ]);

        Estado::create(['uf'=>'TO', 'estado' => 'Tocantins', ]);
        Estado::create(['uf'=>'AC', 'estado' => 'Acre', ]);
        Estado::create(['uf'=>'AM', 'estado' => 'Amazonas', ]);
        Estado::create(['uf'=>'PA', 'estado' => 'Pará', ]);
        Estado::create(['uf'=>'RO', 'estado' => 'Rondônia', ]);
        Estado::create(['uf'=>'RR', 'estado' => 'Roraima', ]);
        Estado::create(['uf'=>'AP', 'estado' => 'Amapá', ]);


        Estado::create(['uf'=>'MA', 'estado' => 'Maranhão', ]);
        Estado::create(['uf'=>'PI', 'estado' => 'Piauí', ]);
        Estado::create(['uf'=>'CE', 'estado' => 'Ceará', ]);
        Estado::create(['uf'=>'RN', 'estado' => 'Rio Grande do Norte', ]);
        Estado::create(['uf'=>'PB', 'estado' => 'Paraíba', ]);
        Estado::create(['uf'=>'PE', 'estado' => 'Pernanbuco', ]);
        Estado::create(['uf'=>'AL', 'estado' => 'Alagoas', ]);
        Estado::create(['uf'=>'SE', 'estado' => 'Sergipe', ]);
        Estado::create(['uf'=>'BA', 'estado' => 'Bahia', ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estados');
    }
}
