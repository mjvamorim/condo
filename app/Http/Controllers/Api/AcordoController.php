<?php

namespace App\Http\Controllers\Api;

use App\Models\Acordo;
use App\Models\Debito;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcordoController extends Controller
{

    public function __construct()
    {
        $this->middleware('tenant');
    }
    public function index(Request $request)
    {

        $clausulaWhere = $this->clausulaWhere($request);
        $acordos = Acordo::select()->where($clausulaWhere)
        ->orderBy('unidade_id')->get();
        return $acordos;
    }

    public static function clausulaWhere(Request $request) {
        $clausulaWhere = [];
        if ($request->input('unidade_id') && $request->input('unidade_id')!='00') {
            $clausulaWhere[] = ['unidade_id',$request->input('unidade_id')];
        }
        if ($request->input('acordo_id') && $request->input('acordo_id')!='0') {
            $clausulaWhere[] = ['id',$request->input('acordo_id')];
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
        $acordo = new Acordo;
        $input =  $request->only($acordo->fillable);
        $acordo->fill($input);
        $acordo->save();
        return $acordo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Acordo  $acordo
     * @return \Illuminate\Http\Response
     */
    public function show(Acordo $acordo)
    {
        return $acordo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Acordo  $acordo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acordo $acordo)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();

        $acordo->update($input);

        return $acordo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Acordo  $acordo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acordo $acordo)
    {
        $acordo->delete();
        return response(['message'=>'Deleted']);
    }

    public function gerarAcordo(Request $request)
    {
        $acordoNovo = $request->all();
        //Grava Acordo
        $acordo = new Acordo;
        $input =  $request->only($acordo->fillable);
        $acordo->fill($input);
        $acordo->save();
        //Quita os debitos do acordo (dtpagto, acordo_quitacao_id)
        $composicao=[];
        foreach( $acordoNovo['debitosSelecionados'] as $d){
            $debito = Debito::find($d['id']);
            $debito->acordo_quitacao_id = $acordo['id'];
            $debito->dtpagto            = $acordo['data'];
            $debito->save();
            $composicao[] = $debito;
        }

        //Cria os Debitos do Acordo ()
        $prestacoes=[];
        foreach($acordoNovo['prestacoes'] as $p){
            $debito = new Debito;
            $debito->tipo       = 'Acordo';
            $debito->unidade_id = $acordo['unidade_id'];
            $debito->acordo_id  = $acordo['id'];
            $debito->dtvencto   = $p['vencto'];
            $debito->valor      = $p['valor'];
            $debito->remessa    = 'N';
            $debito->save();
            $debito->boleto = $debito->id;
            $debito->save();
            $prestacoes[] = $debito;
        }
        
        return response(['message'=>'gerado','acordo'=>$acordo,'composicao'=>$composicao,'prestacoes'=>$prestacoes]);
    }


}
