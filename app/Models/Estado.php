<?php

namespace App\Models;

use Amorim\Tenant\Models\BaseModelTenantMain;

class Estado extends BaseModelTenantMain
{
    protected $primaryKey = 'uf';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'uf','estado', ];
        
    protected $rules = [
        'uf' => 'required|min:2|max:2',
        'estado' => 'required|min:4|max:40',
    ];

    protected $showable = [
        ['name'=>'uf',           'title'=>'Nome',        'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'2'],
        ['name'=>'estado',       'title'=>'Email',       'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'4'],
    ];

}
