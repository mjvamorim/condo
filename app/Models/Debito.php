<?php

namespace App\Models;

use Amorim\Tenant\Models\BaseModelTenant;
use Carbon\Carbon;

class Debito extends BaseModelTenant
{
    protected $fillable = [
        'id', 'unidade_id', 'tipo', 'taxa_id', 'acordo_id',
        'dtvencto', 'valor', 'obs', 'dtpagto', 'valorpago', 'acordo_quitacao_id',
        'remessa', 'boleto',
    ];
    protected $appends = ['valoratual', 'temDebitosAnteriores', 'temAcordosVencer'];

    protected $rules = [
        'id' => 'required',
        'unidade_id' => 'required',
        'tipo' => 'required',
        // 'taxa_id' => 'required',
        // 'acordo_id' => 'required',
        'dtvencto' => 'required',
        'valor' => 'required',
        // 'obs' => 'required',
        'dtpagto' => 'nullable|date',
        // 'valorpago' => 'required',
        // 'acordo_quitacao_id' => 'required',
    ];

    protected $showable = [
        ['name' => 'id', 'title' => 'Id', 'datatable' => 'false', 'form' => 'true', 'type' => 'id'],
        ['name' => 'unidade_id', 'title' => 'Unidade', 'datatable' => 'true', 'form' => 'true', 'type' => 'fk', 'size' => '8',
            'options' => [
                'model' => 'unidade', 'value' => 'id', 'label' => 'descricao', ],
        ],
        ['name' => 'tipo', 'title' => 'Tipo', 'datatable' => 'true', 'form' => 'true', 'type' => 'select', 'size' => '5',
            'options' => [
                ['value' => 'Avulso', 'label' => 'Avulso'],
                ['value' => 'Mensalidade', 'label' => 'Mensalidade'],
                ['value' => 'Acordo', 'label' => 'Acordo'],
                ['value' => 'Multa', 'label' => 'Multa'],
            ],
        ],
        ['name' => 'taxa_id', 'title' => 'Taxa', 'datatable' => 'false', 'form' => 'true', 'type' => 'fk', 'size' => '8',
            'options' => [
                'model' => 'taxa', 'value' => 'id', 'label' => 'anomes', ],
        ],
        ['name' => 'acordo_id', 'title' => 'Acordo', 'datatable' => 'false', 'form' => 'true', 'type' => 'fk', 'size' => '8',
            'options' => [
                'model' => 'acordo', 'value' => 'id', 'label' => 'id', ],
        ],
        ['name' => 'obs', 'title' => 'Obs.:', 'datatable' => 'false', 'form' => 'true', 'type' => 'textarea', 'size' => '8'],
        ['name' => 'dtvencto', 'title' => 'Dt.Vencto', 'datatable' => 'true', 'form' => 'true', 'type' => 'date', 'size' => '5'],
        ['name' => 'valor', 'title' => 'Valor', 'datatable' => 'true', 'form' => 'true', 'type' => 'money', 'size' => '5'],
        ['name' => 'dtpagto', 'title' => 'Dt.Pagto', 'datatable' => 'true', 'form' => 'true', 'type' => 'date', 'size' => '5'],
        ['name' => 'valorpago', 'title' => 'Vl.Pago', 'datatable' => 'true', 'form' => 'true', 'type' => 'money', 'size' => '5'],
        ['name' => 'acordo_quitacao_id', 'title' => 'Acordo Quitação', 'datatable' => 'false', 'form' => 'false', 'type' => 'fk', 'size' => '8',
            'options' => [
                'model' => 'acordo', 'value' => 'id', 'label' => 'id', ],
        ],
        ['name' => 'remessa', 'title' => 'Remessa', 'datatable' => 'false', 'form' => 'true', 'type' => 'select', 'size' => '5', 'readonly' => 'true',
            'options' => [
                ['value' => 'N', 'label' => 'Não'],
                ['value' => 'S', 'label' => 'Sim'],
            ],
        ],
        ['name' => 'boleto', 'title' => 'Boleto', 'datatable' => 'true', 'form' => 'false', 'type' => 'hidden', 'size' => '5'],
        // ['name'=>'valor_atualizado',    'title'=>'Valor Atual',      'datatable'=>'true', 'form'=>'false','type'=>'text', 'size'=>'5'],
    ];

    protected $actions = [
        ['ini' => '<button class="btn edit" id="',
            'fim' => '" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>',
        ],
        ['ini' => '<button class="btn delt" id="',
            'fim' => '" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>',
        ],
        ['ini' => '<button class="btn boleto"  onclick="location.href=\'/financeiro/imprimirBoletos?debito_id=',
            'fim' => '\'"  title="Boleto" data-toggle="tooltip" ><i class="glyphicon glyphicon-barcode"></i> </button>',
        ],
        ['ini' => '<button class="btn email"  id="',
            'fim' => '"  title="Boleto por Email" data-toggle="tooltip" ><i class="glyphicon glyphicon-envelope"></i> </button>',
        ],
    ];

    public function unidade()
    {
        return $this->belongsTo('App\Models\Unidade', 'unidade_id');
    }

    public function taxa()
    {
        return $this->belongsTo('App\Models\Taxa', 'taxa_id');
    }

    public function acordo()
    {
        return $this->belongsTo('App\Models\Acordo', 'acordo_id');
    }

    public function acordo_quitacao()
    {
        return $this->belongsTo('App\Models\Acordo', 'acordo_quitacao_id');
    }

    public function getValoratualAttribute()
    {
        $valor_atualizado = 0;
        $hoje = Carbon::now();
        $vencto = Carbon::createFromFormat('Y-m-d', $this->dtvencto);
        $dias_atraso = $vencto->diffInDays($hoje, false);
        if (is_null($this->dtpagto)) {
            $valor_atualizado = $this->valor;
            if ($dias_atraso > 0) {
                $multa = $this->valor * 0.02;
                $juros = $this->valor * $dias_atraso * 0.00033333333;
                $valor_atualizado = $this->valor + $multa + $juros;
            }
        }

        return $valor_atualizado;
    }

    public function getTemDebitosAnterioresAttribute()
    {
        $hoje = Carbon::now();
        $clausulaWhere = [];
        $clausulaWhere[] = ['unidade_id', $this->unidade_id];
        $clausulaWhere[] = ['dtvencto', '<=', $hoje];
        $clausulaWhere[] = ['dtpagto', null];
        $debitos = Debito::where($clausulaWhere)->first();

        return null !== $debitos;
    }

    public function getTemAcordosVencerAttribute()
    {
        $temAcordosVencer = false;
        $hoje = Carbon::now();
        $clausulaWhere = [];
        $clausulaWhere[] = ['unidade_id', $this->unidade_id];
        $clausulaWhere[] = ['tipo', '=', 'Acordo'];
        $clausulaWhere[] = ['dtvencto', '>=', $hoje];
        $clausulaWhere[] = ['dtpagto', null];
        $debitos = Debito::where($clausulaWhere)->first();

        return null !== $debitos;
    }
}
