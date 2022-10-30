<?php

namespace App\Models;
use Amorim\Tenant\Models\BaseModelTenant;
use App\Models\Proprietario;

class Unidade extends BaseModelTenant
{
    protected $fillable = [
        'id','descricao', 'adicional', 'tipo_adicional', 'proprietario_id', 'moradores', 'veiculos', 'ramal', 'obs','envio_boleto'
    ];

    protected $rules = [
        'descricao' => 'required|min:2|max:50',
        'proprietario_id' => 'required',

    ];

    protected $showable = [
        ['name'=>'id',              'title'=>'Id',              'datatable'=>'false',  'form'=>'true',  'type'=>'id',   'size'=>'3',],
        ['name'=>'descricao',       'title'=>'Descricao',       'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'3',],
        ['name'=>'tipo_adicional',  'title'=>'Tipo Adicional',   'datatable'=>'false', 'form'=>'true',  'type'=>'select', 'size'=>'3',
        'options'=> [
            ['value'=>'Valor Fixo','label'=>'Valor Fixo'],
            ['value'=>'Percentual','label'=>'Percentual'],
        ],
        ],
        ['name'=>'adicional',        'title'=>'Adicional',      'datatable'=>'false',  'form'=>'true',  'type'=>'number', 'size'=>'3', 'step'=>'0.01',],
        ['name'=>'proprietario_id',  'title'=>'Proprietario',   'datatable'=>'true',  'form'=>'true',  'type'=>'fk',   'size'=>'8',
            'options'=> [
                'model'=>'proprietario', 'value'=>'id','label'=>'nome',],
        ],
        ['name'=>'moradores',         'title'=>'Moradores', 'datatable'=>'true', 'form'=>'true',  'type'=>'textarea', 'size'=>'8',],
        ['name'=>'veiculos',          'title'=>'Veículos',  'datatable'=>'true', 'form'=>'true',  'type'=>'textarea', 'size'=>'8',],
        ['name'=>'ramal',             'title'=>'Ramal',     'datatable'=>'true', 'form'=>'true',  'type'=>'text', 'size'=>'3',],
        ['name'=>'obs',             'title'=>'Observação',  'datatable'=>'false', 'form'=>'true',  'type'=>'textarea', 'size'=>'8',],
        ['name'=>'envio_boleto', 'title'=>'Envio Boleto',   'datatable'=>'false', 'form'=>'true',  'type'=>'select', 'size'=>'3',
            'options'=> [
                ['value'=>'Ambos','label'=>'Ambos'],
                ['value'=>'Impresso','label'=>'Impresso'],
                ['value'=>'Email','label'=>'Email'],
            ],
        ],
    ];

    public function proprietario()
    {
        //return $this->hasOne(\App\Models\Proprietario::class,'id','proprietario_id');
        return $this->belongsTo(\App\Models\Proprietario::class,'proprietario_id');
    }


    protected $actions = [
        [   'ini'=>'<button class="btn edit" id="',
            'fim'=>'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>',
        ],
        [   'ini'=>'<button class="btn delt" id="',
            'fim'=>'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>',
        ],
        [   'ini'=>'<button class="btn boleto"  onclick="location.href=\'/debitos?unidade_id=',
            'fim'=>'\'"  title="Débitos" data-toggle="tooltip" ><i class="glyphicon glyphicon-th-list"></i> </button>',
        ],
        [   'ini'=>'<button class="btn proprietarios"  onclick="location.href=\'/crud/proprietario?id=',
            'fim'=>'\'"  title="Proprietarios" data-toggle="tooltip" ><i class="glyphicon glyphicon-tower"></i> </button>',
            'campo'=>'proprietario_id',
        ],
    ];
}

