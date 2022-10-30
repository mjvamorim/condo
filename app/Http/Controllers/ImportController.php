<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Excell;
use App\Models\Taxa;
use App\Models\Unidade;
use App\Models\Debito;

class ImportController extends Controller
{
    function index()  {

        return view('FrmImportacao', compact('data'));
    }

    public function importacao(Request $request) {

        $path = $request->file('file')->getRealPath();
        $saida = '';
        $data = \Excel::load($path)->get();
        if($data->count() > 0) {
            foreach($data->toArray() as $key => $value)  {
                foreach($value as $row)  {
                    $ano = str_pad($row['ano'], 4, "0", STR_PAD_LEFT);
                    $mes = str_pad($row['mes'], 2, "0", STR_PAD_LEFT);

                    $descricao = 'Bloco '.str_pad($row['bloco'], 2, "0", STR_PAD_LEFT).' Apto '.str_pad($row['apto'],4,"0",STR_PAD_LEFT);
                    $unidade = Unidade::where('descricao', '=', $descricao)->first();
                    if ($unidade) {
                        //Procura o Taxa e cria se não existir
                        $taxa = Taxa::where('anomes', '=', $ano.'-'.$mes) ->first();
                        if (!$taxa) {
                            $taxa = new Taxa;
                            $taxa->anomes = $ano.'-'.$mes;
                            $taxa->dtvencto = $ano.'-'.$mes.'-'.'25';
                            $taxa->valor = 152;
                            $taxa->save();
                        }
                        //Procura o débito e cria se não existir
                        $debito = Debito::where('taxa_id', '=', $taxa->id)
                            ->where('unidade_id', '=', $unidade->id)
                            ->first();
                        if (!$debito) {
                            $debito = new Debito;
                        }
                        if ($debito->dtpagto == null){
                            $debito->unidade_id         = $unidade->id;
                            $debito->tipo               = 'Mensalidade';
                            $debito->taxa_id            = $taxa->id;
                            $debito->acordo_id          = null;
                            $debito->dtvencto           = $taxa->dtvencto;
                            if ($unidade->tipo_adicional == 'Percentual') {
                                $debito->valor              = $taxa->valor * (1 + $unidade->adicional/100);
                            }
                            else {
                                $debito->valor              = $taxa->valor + $unidade->adicional;
                            }
                            $debito->obs                = '';
                            $debito->dtpagto            = null;
                            $debito->valorpago          = null;
                            $debito->acordo_quitacao_id = null;
                            $debito->save();
                            $debito->boleto             = $debito->id;
                            $debito->save();
                        }
                        $saida .= $unidade->descricao.PHP_EOL;
                    }
                    $saida .= $unidade->descricao.PHP_EOL;
                    // localizar a Unidade pelo bloco e apartamento


                }
            }

        }
        $saida .= PHP_EOL .PHP_EOL;
        return response()->json($saida);

    }

}


