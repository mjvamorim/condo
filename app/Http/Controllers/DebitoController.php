<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Debito;
use App\Models\Unidade;
use App\Models\Proprietario;
use Validator;
use Response;
use DataTables;
use \DB;


class DebitoController extends Controller
{

    private $actions;

    public function __construct()
    {
        $this->middleware('tenant');
    }

    function index(Request $request)
    {
        $proprietario_id = $request->query('proprietario_id');
        $unidade_id = $request->query('unidade_id');
        $showables  = Debito::getShowableFields();
        $unidades = Unidade::all();
        $proprietarios = Proprietario::all()->sortBy('nome');
        return view('FrmDebitos',compact('showables','unidade_id','unidades','proprietario_id','proprietarios'));
    }

     //-------------------------clausulaWhere-------------------------------//
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

    function getData(Request $request)
    {
        $model = 'debito';
        $clausulaWhere = $this->clausulaWhere($request);

        // $collection = DB::connection('tenant')->table('debitos')
        //     ->select(DB::raw('debitos.id, debitos.tipo, debitos.dtvencto, debitos.valor,
        //     debitos.dtpagto, debitos.valorpago, debitos.boleto'))
        //     ->join('unidades', 'debitos.unidade_id', '=', 'unidades.id')
        //     ->join('proprietarios', 'unidades.proprietario_id', '=', 'proprietarios.id')
        //     ->where($clausulaWhere)
        //     ->orderBy('dtvencto','desc')
        // ->get();


        $class = config('crud.'.$model);
        $showables  = $class::getShowableFields();
        $this->actions    = $class::getActions();
        $clausulaWith = [];
        foreach ($showables as $field) {
            if (($field['type']=='fk') && ($field['datatable']=='true')) {
                $clausulaWith[] = $field['options']['model'];
            }
        }

        if (count($clausulaWith)>0) {
            $debitos = $class::select()
            ->with($clausulaWith)
            ->where($clausulaWhere)
            ->orderBy('dtvencto','desc')
            ->get();
        }
        else {
            $debitos = $class::select()->where($clausulaWhere)->orderBy('dtvencto','desc');
        }

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

        return DataTables::of($debitos)
            ->addColumn('valor_atualizado', function($model){
                return $model->valoratual;
            })
            ->addColumn('action', function($model){
                if($this->actions == NULL) {
                    $btedit = '<button class="btn edit" id="'.$model->id.'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>';
                    $btdelt = '<button class="btn delt" id="'.$model->id.'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>';
                    return '<div align="center">'.$btedit.'<span> </span>'.$btdelt.'</div>';
                }
                else {
                    $text = '<div align="center">';
                    foreach($this->actions as $action){
                        $text .= $action['ini'].$model->id.$action['fim'];
                    }
                    $text .= '</div>';
                    return $text;
                }
            })
            ->make(true);
    }

    function fetchData(Request $request, $model )
    {

        $class = config('crud.'.$model);
        $id = $request->input('id');
        $item = $class::find($id);
        echo json_encode($item);
    }


    function postData(Request $request, $model)
    {
        $class = config('crud.'.$model);
        if($request->get('button_action') == 'delete')
        {
            $id = $request->input('id');

            $deleted = $class::destroy($id);
            if ($deleted) {
                $error_array = [];
                $success_output = '<div class="alert alert-success">Data Deleted</div>';
            } else {
                $success_output = '<div class="alert alert-danger">Data Deleted</div>';
                $error_array = [];
            }

        }
        else {

            $rules = $class::getRules();
            $validation = Validator::make($request->all(), $class::getRules());
            $error_array = array();
            $success_output = '';
            if ($validation->fails())
            {
                foreach ($validation->messages()->getMessages() as $field_name => $messages)
                {
                    $error_array[] = $messages;
                }
            }
            else
            {
                if($request->get('button_action') == 'insert')
                {
                    $item = new $class;
                    $input =  $request->only($item->fillable);
                    $item->fill($input);
                    $item->save();
                    $success_output = '<div class="alert alert-success">Data Inserted</div>';
                }

                if($request->get('button_action') == 'update')
                {
                    $item = $class::find($request->get('id'));
                    $input =  $request->only($item->fillable);
                    $item->fill($input);
                    $item->save();
                    $success_output = '<div class="alert alert-success">Data Updated</div>';
                }
            }
        }

        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output,
            'eu'        => 'Mauricio Amorim',
        );
        echo json_encode($output);
    }
}
