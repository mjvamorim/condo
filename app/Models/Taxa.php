<?php

namespace App\Models;
use Amorim\Tenant\Models\BaseModelTenant;

class Taxa extends BaseModelTenant
{
    protected $fillable = [
        'id','anomes', 'dtvencto', 'valor', 
    ];
        
    protected $rules = [
        'anomes' => 'required',     
        'valor' => 'required',
        'dtvencto' => 'required',
        
    ];

    protected $showable = [
        ['name'=>'id',       'title'=>'Id',        'datatable'=>'false', 'form'=>'true', 'type'=>'id'   , 'size'=>'4' ],
        ['name'=>'anomes',   'title'=>'Ano/Mes',   'datatable'=>'true',  'form'=>'true', 'type'=>'text' , 'size'=>'4' , 'mask'=>'0000-00'],
        ['name'=>'dtvencto', 'title'=>'Vencimento','datatable'=>'true',  'form'=>'true', 'type'=>'date' , 'size'=>'4' ], 
        ['name'=>'valor',    'title'=>'Valor',     'datatable'=>'true',  'form'=>'true', 'type'=>'money', 'size'=>'4' ], 
    ];
}
