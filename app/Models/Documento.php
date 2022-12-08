<?php

namespace App\Models;

use Amorim\Tenant\Models\BaseModelTenant;

class Debito extends BaseModelTenant
{
    protected $fillable = [
        'id', 'unidade_id', 'descricao', 'arquivo',
    ];
    protected $appends = [];

    protected $rules = [
        'id' => 'required',
        'unidade_id' => 'required',
        'descricao' => 'required',
        'arquivo' => 'required',
    ];

    protected $showable = [
        ['name' => 'id', 'title' => 'Id', 'datatable' => 'false', 'form' => 'true', 'type' => 'id'],
        ['name' => 'unidade_id', 'title' => 'Unidade', 'datatable' => 'true', 'form' => 'true', 'type' => 'fk', 'size' => '8',
            'options' => [
                'model' => 'unidade', 'value' => 'id', 'label' => 'descricao', ],
        ],
        ['name' => 'descricao', 'title' => 'Descricao:', 'datatable' => 'true', 'form' => 'true', 'type' => 'textarea', 'size' => '8'],
        ['name' => 'arquivo', 'title' => 'Arquivo', 'datatable' => 'false', 'form' => 'true', 'type' => 'textarea', 'size' => '8'],
    ];

    protected $actions = [
        ['ini' => '<button class="btn edit" id="',
            'fim' => '" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>',
        ],
        ['ini' => '<button class="btn delt" id="',
            'fim' => '" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>',
        ],
    ];

    public function unidade()
    {
        return $this->belongsTo('App\Models\Unidade', 'unidade_id');
    }
}
