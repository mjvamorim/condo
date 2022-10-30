<?php

namespace Amorim\Tenant\Models;
use \Amorim\Tenant\Models\BaseModelTenantMain;


class Empresa extends BaseModelTenantMain
{
    protected $fillable = [
        'id','nome', 'cpf','cep', 'rua','numero',
        'bairro', 'complemento', 'cidade',
        'uf','pais','email','celular','fixo',
        'banco', 'agencia', 'conta','digito','carteira','convenio',
        'db_host', 'db_database', 'db_username', 'db_password', ];
        
    protected $rules = [
        'nome' => 'required|min:5|max:50',
        'email' => 'required|email',
        'cep' => 'required',
        'numero' => 'required'
    ];

    protected $showable = [
        ['name'=>'id',           'title'=>'Id',          'datatable'=>'true', 'form'=>'false', 'type'=>'id',   ],
        ['name'=>'nome',         'title'=>'Nome',        'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'email',        'title'=>'Email',       'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'celular',      'title'=>'Celular',     'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'4', 'mask'=>'(000)00000-0000', ], 
        ['name'=>'fixo',         'title'=>'Tel.Fixo',    'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'4', 'mask'=>'(000)00000-0000', ],
        ['name'=>'cpf',          'title'=>'Cpf ou CNPJ', 'datatable'=>'true',  'form'=>'true',  'type'=>'text', 'size'=>'4', ],
        ['name'=>'cep',          'title'=>'Cep',         'datatable'=>'false', 'form'=>'true',  'type'=>'cep',  'size'=>'3', 'mask'=>'00000-000', ],
        ['name'=>'rua',          'title'=>'Rua',         'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'numero',       'title'=>'Numero',      'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'2', ],
        ['name'=>'complemento',  'title'=>'Complemento', 'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'8', ],
        ['name'=>'bairro',       'title'=>'Bairro',      'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'4', ],
        ['name'=>'cidade',       'title'=>'Cidade',      'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'4', ],
        ['name'=>'uf',           'title'=>'UF',          'datatable'=>'false', 'form'=>'true',  'type'=>'fk', 'size'=>'8',         
             'options'=> ['model'=>'estado', 'value'=>'uf','label'=>'estado',],
        ],
        ['name'=>'pais',         'title'=>'Pais',        'datatable'=>'false', 'form'=>'true',  'type'=>'text', 'size'=>'4', ],
        //Dados Bancários
        ['name'=>'banco',        'title'=>'Banco',       'datatable'=>'false', 'form'=>'true',  'type'=>'select', 'size'=>'4', 
            'options'=> [
                ['value'=>'1','label'=>'Banco do Brasil'],
                ['value'=>'33','label'=>'Santander'],
                ['value'=>'41','label'=>'Banrisul'],
                ['value'=>'104','label'=>'Caixa Economica'],
                ['value'=>'237','label'=>'Bradesco'],
                ['value'=>'341','label'=>'Itaú'],
                ['value'=>'399','label'=>'HSBC'],
                ['value'=>'748','label'=>'Sicred'],
                ['value'=>'756','label'=>'Sicoob'],
            ], 
        ],
        ['name'=>'agencia',      'title'=>'Agencia',     'datatable'=>'false', 'form'=>'true',  'type'=>'number', 'size'=>'4', 'mask'=>'0000',   'step'=>'1',],
        ['name'=>'conta',        'title'=>'Conta',       'datatable'=>'false', 'form'=>'true',  'type'=>'number', 'size'=>'4', 'mask'=>'00000',  'step'=>'1',],
        ['name'=>'digito',       'title'=>'Digito',      'datatable'=>'false', 'form'=>'true',  'type'=>'number', 'size'=>'4', 'mask'=>'0',      'step'=>'1',],
        ['name'=>'carteira',     'title'=>'Carteira',    'datatable'=>'false', 'form'=>'true',  'type'=>'number', 'size'=>'4', 'mask'=>'000',    'step'=>'1',],
        ['name'=>'convenio',     'title'=>'Convênio',    'datatable'=>'false', 'form'=>'true',  'type'=>'number', 'size'=>'4', 'mask'=>'0000000','step'=>'1', ],
        
        //Conexao com o banco
        ['name'=>'db_host',      'title'=>'Db_host',     'datatable'=>'false', 'form'=>'false',  'type'=>'text', 'size'=>'4',],
        ['name'=>'db_database',  'title'=>'Db_database', 'datatable'=>'false', 'form'=>'false',  'type'=>'text', 'size'=>'4',],
        ['name'=>'db_username',  'title'=>'Db_username', 'datatable'=>'false', 'form'=>'false',  'type'=>'text', 'size'=>'4',],
        ['name'=>'db_password',  'title'=>'Db_password', 'datatable'=>'false', 'form'=>'false',  'type'=>'text', 'size'=>'4',],
    ];

    protected $actions = [
        [   'ini'=>'<button class="btn edit" id="', 
            'fim'=>'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>',
        ],
        [   'ini'=>'<button class="btn delt" id="', 
            'fim'=>'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>',
        ],
        [   'ini'=>'<button class="btn boleto"  onclick="location.href=\'/user?empresa_id=', 
            'fim'=>'\'"  title="Usuarios" data-toggle="tooltip" ><i class="glyphicon glyphicon-user"></i> </button>',
        ],             
         
    ];


}
