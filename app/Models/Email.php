<?php

namespace App\Models;
use Amorim\Tenant\Models\BaseModelTenant;

class Email extends BaseModelTenant
{
    protected $fillable = [
        'id','created_at', 'de', 'para', 'assunto','mensagem','anexo',
    ];

    protected $rules = [
    ];

    protected $showable = [
        ['name'=>'id',          'title'=>'Id',          'datatable'=>'true',  'form'=>'true',  'type'=>'id',   'size'=>'2', ],
        ['name'=>'created_at',  'title'=>'Data Envio',  'datatable'=>'true',  'form'=>'true',  'type'=>'datetime', 'size'=>'4', ],
        ['name'=>'de',          'title'=>'Remetente',   'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'para',        'title'=>'Destinatário','datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'assunto',     'title'=>'Assunto',     'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'anexo',       'title'=>'Anexo',       'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'mensagem',    'title'=>'Mensagem',    'datatable'=>'true',  'form'=>'true',  'type'=>'textarea', 'size'=>'8', ],
    ];


    protected $actions = [
        [   'ini'=>'<button class="btn edit" id="',
            'fim'=>'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>',
        ],
        [   'ini'=>'<button class="btn delt" id="',
            'fim'=>'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>',
        ],
    ];

}
