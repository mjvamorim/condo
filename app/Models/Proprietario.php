<?php

namespace App\Models;

use Amorim\Tenant\Models\BaseModelTenant;

class Proprietario extends BaseModelTenant
{
    protected $fillable = [
        'id', 'nome', 'cpf', 'conjuge_nome', 'conjuge_cpf', 'cep', 'rua', 'numero',
        'bairro', 'complemento', 'cidade',
        'uf', 'pais', 'email', 'celular', 'fixo',
    ];

    protected $rules = [
        'nome' => 'required|min:5|max:50',
        'email' => 'nullable|email',
        'cpf' => 'required',
        'cep' => 'required',
        'numero' => 'required',
    ];

    protected $showable = [
        ['name' => 'id', 'title' => 'Id', 'datatable' => 'true', 'form' => 'true', 'type' => 'id', 'size' => '2'],
        ['name' => 'nome', 'title' => 'Nome', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '8'],
        ['name' => 'email', 'title' => 'Email', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '8'],
        ['name' => 'celular', 'title' => 'Celular', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '4', 'mask' => '(000)00000-0000'],
        ['name' => 'fixo', 'title' => 'Tel.Fixo', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '4', 'mask' => '(000)00000-0000'],
        ['name' => 'cpf', 'title' => 'CPF', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '3', 'mask' => '000.000.000-00'],
        ['name' => 'conjuge_nome', 'title' => 'Nome do Conjuge', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '8'],
        ['name' => 'conjuge_cpf', 'title' => 'CPF do Conjuge', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '3', 'mask' => '000.000.000-00'],
        ['name' => 'cep', 'title' => 'Cep', 'datatable' => 'false', 'form' => 'true', 'type' => 'cep', 'size' => '3', 'mask' => '00000-000'],
        ['name' => 'rua', 'title' => 'Rua', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '8'],
        ['name' => 'numero', 'title' => 'Numero', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '2'],
        ['name' => 'complemento', 'title' => 'Complemento', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '8'],
        ['name' => 'bairro', 'title' => 'Bairro', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '4'],
        ['name' => 'cidade', 'title' => 'Cidade', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '4'],
        ['name' => 'uf', 'title' => 'UF', 'datatable' => 'false', 'form' => 'true', 'type' => 'fk', 'size' => '8',
            'options' => ['model' => 'estado', 'value' => 'uf', 'label' => 'estado'],
        ],
        ['name' => 'pais', 'title' => 'Pais', 'datatable' => 'false', 'form' => 'true', 'type' => 'text', 'size' => '4'],
    ];

    protected $actions = [
        ['ini' => '<button class="btn edit" id="',
            'fim' => '" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>',
        ],
        ['ini' => '<button class="btn delt" id="',
            'fim' => '" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>',
        ],
        ['ini' => '<button class="btn unidades"  onclick="location.href=\'/crud/unidade?proprietario_id=',
            'fim' => '\'"  title="Unidades" data-toggle="tooltip" ><i class="glyphicon glyphicon-home"></i> </button>',
        ],
    ];

    public function unidades()
    {
        return $this->hasMany(\App\Models\Unidade::class);
    }

    public function estado()
    {
        return $this->hasOne(\App\Models\Estado::class, 'uf', 'uf');
    }
}
