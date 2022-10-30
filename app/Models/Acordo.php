<?php

namespace App\Models;
use Amorim\Tenant\Models\BaseModelTenant;

class Acordo extends BaseModelTenant
{
    protected $fillable = [
        'id','unidade_id', 'data', 'termos', 
    ];
        
    protected $rules = [
        'data' => 'required',
        'unidade_id' => 'required',
    ];

    protected $showable = [
        ['name'=>'id',           'title'=>'Id',          'datatable'=>'true', 'form'=>'true',   'type'=>'id',  'size'=>'4' ],
        ['name'=>'unidade_id',   'title'=>'Unidade',     'datatable'=>'true',  'form'=>'true',  'type'=>'fk', 'size'=>'4',
            'options'=> [ 'model'=>'unidade', 'value'=>'id','label'=>'descricao',]
        ],
        ['name'=>'data',         'title'=>'Data',        'datatable'=>'true',  'form'=>'true',  'type'=>'date','size'=>'4' ],
        ['name'=>'termos',       'title'=>'Termos',      'datatable'=>'true',  'form'=>'true',  'type'=>'textarea','size'=>'8' ],
    ];

    public function unidade() { return $this->belongsTo('App\Models\Unidade'); }

}
