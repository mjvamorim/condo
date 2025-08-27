<?php

namespace App\Http\Controllers\Api;

use App\Models\Debito;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DebitoController extends Controller
{

    public function __construct()
    {
        $this->middleware('tenant');
    }
    public function index(Request $request)
    {

        // $ordem = $request->input('ordem') ?  $request->input('ordem') : 'unidade';

        $clausulaWhere = $this->clausulaWhere($request);
        //$debitos = Debito::all();
        $debitos = Debito::select()->where($clausulaWhere)
        // ->orderBy($ordem,'asc')
        ->orderBy('dtvencto','desc')->get();

        if ($request->input('proprietario_id') && $request->input('proprietario_id')!='00') {
            $filtered = [];
            foreach($debitos as $debito){
                if($debito->unidade->proprietario_id == $request->input('proprietario_id') ){
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }

        if ($request->input('envio_boleto') && $request->input('envio_boleto')!='Todos') {
            $filtered = [];
            foreach($debitos as $debito){
                if($debito->unidade->envio_boleto == $request->input('envio_boleto') or $debito->unidade->envio_boleto == 'Ambos'){
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }
        if ($request->input('descricao') && $request->input('descricao')!='') {
            $filtered = [];
            foreach($debitos as $debito){
                if(stripos($debito->unidade->descricao, $request->input('descricao')) !== false){
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }
        return $debitos;
    }

    public static function clausulaWhere(Request $request) {
        $clausulaWhere = [];
        if ($request->input('taxa_id') && $request->input('taxa_id')!='00') {
            $clausulaWhere[] = ['taxa_id','=',$request->input('taxa_id')];
        }
        if ($request->input('unidade_id') && $request->input('unidade_id')!='00') {
            $clausulaWhere[] = ['unidade_id',$request->input('unidade_id')];
        }
        if ($request->input('debito_id') && $request->input('debito_id')!='0') {
            $clausulaWhere[] = ['id',$request->input('debito_id')];
        }
        if ($request->input('acordo_id') && $request->input('acordo_id')!='0') {
            $clausulaWhere[] = ['acordo_id',$request->input('acordo_id')];
        }
        if ($request->input('acordo_quitacao_id') && $request->input('acordo_quitacao_id')!='0') {
            $clausulaWhere[] = ['acordo_quitacao_id',$request->input('acordo_quitacao_id')];
        }

        if ($request->input('tipo_id') && $request->input('tipo_id')!='Todos') {
            $clausulaWhere[] = ['tipo',$request->input('tipo_id')];
        }

        switch($request->input('condicao')) {
            case 'Pagos':
                if ($request->input('dtini') && $request->input('dtini')!='') {
                    $clausulaWhere[] = ['dtpagto','>=',$request->input('dtini')];
                }
                if ($request->input('dtfim') && $request->input('dtfim')!='') {
                    $clausulaWhere[] = ['dtpagto','<=',$request->input('dtfim')];
                }
                $clausulaWhere[] = ['dtpagto', '<>',NULL];
                break;
            case 'Abertos':
                if ($request->input('dtini') && $request->input('dtini')!='') {
                    $clausulaWhere[] = ['dtvencto','>=',$request->input('dtini')];
                }
                if ($request->input('dtfim') && $request->input('dtfim')!='') {
                    $clausulaWhere[] = ['dtvencto','<=',$request->input('dtfim')];
                }
                $clausulaWhere[] = ['dtpagto', NULL];

            default:
                if ($request->input('dtini') && $request->input('dtini')!='') {
                    $clausulaWhere[] = ['dtvencto','>=',$request->input('dtini')];
                }
                if ($request->input('dtfim') && $request->input('dtfim')!='') {
                    $clausulaWhere[] = ['dtvencto','<=',$request->input('dtfim')];
                }
        }
       return $clausulaWhere;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $debito = new Debito;
        $input =  $request->only($debito->fillable);
        $debito->fill($input);
        $debito->save();
        return $debito;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Debito  $debito
     * @return \Illuminate\Http\Response
     */
    public function show(Debito $debito)
    {
        return $debito;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Debito  $debito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Debito $debito)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();

        $debito->update($input);

        return $debito;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Debito  $debito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debito $debito)
    {
        $debito->delete();
        return response(['message'=>'Deleted']);
    }
     public function clausulaWhereQuery(Request $request) {
        $clausulaWhere = [['debitos.id','>','0']];
        if ($request->input('proprietario_id') && $request->input('proprietario_id')!='00') {
            $clausulaWhere[] = ['unidades.proprietario_id','=',$request->input('proprietario_id')];
        }
        if ($request->input('taxa_id') && $request->input('taxa_id')!='00') {
            $clausulaWhere[] = ['debitos.taxa_id','=',$request->input('taxa_id')];
        }
        if ($request->input('unidade_id') && $request->input('unidade_id')!='00') {
            $clausulaWhere[] = ['debitos.unidade_id',$request->input('unidade_id')];
        }
        if ($request->input('debito_id') && $request->input('debito_id')!='0') {
            $clausulaWhere[] = ['debitos.id',$request->input('debito_id')];
        }

        if ($request->input('tipo_id') && $request->input('tipo_id')!='Todos') {
            $clausulaWhere[] = ['debitos.tipo',$request->input('tipo_id')];
        }
        switch($request->input('condicao')) {
            case 'Pagos':
                if ($request->input('dtini') && $request->input('dtini')!='') {
                    $clausulaWhere[] = ['debitos.dtpagto','>=',$request->input('dtini')];
                }
                if ($request->input('dtfim') && $request->input('dtfim')!='') {
                    $clausulaWhere[] = ['debitos.dtpagto','<=',$request->input('dtfim')];
                }
                $clausulaWhere[] = ['debitos.dtpagto', '<>',NULL];
                break;
            case 'Abertos':
                if ($request->input('dtini') && $request->input('dtini')!='') {
                    $clausulaWhere[] = ['debitos.dtvencto','>=',$request->input('dtini')];
                }
                if ($request->input('dtfim') && $request->input('dtfim')!='') {
                    $clausulaWhere[] = ['debitos.dtvencto','<=',$request->input('dtfim')];
                }
                $clausulaWhere[] = ['debitos.dtpagto', NULL];
            break;

            default:
                if ($request->input('dtini') && $request->input('dtini')!='') {
                    $clausulaWhere[] = ['debitos.dtvencto','>=',$request->input('dtini')];
                }
                if ($request->input('dtfim') && $request->input('dtfim')!='') {
                    $clausulaWhere[] = ['debitos.dtvencto','<=',$request->input('dtfim')];
                }
        }
        return $clausulaWhere;
    }
}
