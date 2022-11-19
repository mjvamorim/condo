<?php

namespace App\Http\Controllers;

use App\Models\Debito;
use App\Models\Proprietario;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DebitoController extends Controller
{
    private $actions;

    public function __construct()
    {
        $this->middleware('tenant');
    }

    public function index(Request $request)
    {
        $proprietario_id = $request->query('proprietario_id');
        $unidade_id = $request->query('unidade_id');
        $showables = Debito::getShowableFields();
        $unidades = Unidade::all();
        $proprietarios = Proprietario::all()->sortBy('nome');

        return view('FrmDebitos', compact('showables', 'unidade_id', 'unidades', 'proprietario_id', 'proprietarios'));
    }

     // -------------------------clausulaWhere-------------------------------//
     public static function clausulaWhere(Request $request)
     {
         $clausulaWhere = [];
         if ($request->input('taxa_id') && '00' != $request->input('taxa_id')) {
             $clausulaWhere[] = ['taxa_id', '=', $request->input('taxa_id')];
         }
         if ($request->input('unidade_id') && '00' != $request->input('unidade_id')) {
             $clausulaWhere[] = ['unidade_id', $request->input('unidade_id')];
         }
         if ($request->input('debito_id') && '0' != $request->input('debito_id')) {
             $clausulaWhere[] = ['id', $request->input('debito_id')];
         }

         if ($request->input('tipo_id') && 'Todos' != $request->input('tipo_id')) {
             $clausulaWhere[] = ['tipo', $request->input('tipo_id')];
         }

         switch ($request->input('condicao')) {
             case 'Pagos':
                 if ($request->input('dtini') && '' != $request->input('dtini')) {
                     $clausulaWhere[] = ['dtpagto', '>=', $request->input('dtini')];
                 }
                 if ($request->input('dtfim') && '' != $request->input('dtfim')) {
                     $clausulaWhere[] = ['dtpagto', '<=', $request->input('dtfim')];
                 }
                 $clausulaWhere[] = ['dtpagto', '<>', null];

                 break;

             case 'Abertos':
                 if ($request->input('dtini') && '' != $request->input('dtini')) {
                     $clausulaWhere[] = ['dtvencto', '>=', $request->input('dtini')];
                 }
                 if ($request->input('dtfim') && '' != $request->input('dtfim')) {
                     $clausulaWhere[] = ['dtvencto', '<=', $request->input('dtfim')];
                 }
                 $clausulaWhere[] = ['dtpagto', null];

                 // no break
             default:
                 if ($request->input('dtini') && '' != $request->input('dtini')) {
                     $clausulaWhere[] = ['dtvencto', '>=', $request->input('dtini')];
                 }
                 if ($request->input('dtfim') && '' != $request->input('dtfim')) {
                     $clausulaWhere[] = ['dtvencto', '<=', $request->input('dtfim')];
                 }
         }

         return $clausulaWhere;
     }

    public function getData(Request $request)
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
        $showables = $class::getShowableFields();
        $this->actions = $class::getActions();
        $clausulaWith = [];
        foreach ($showables as $field) {
            if (('fk' == $field['type']) && ('true' == $field['datatable'])) {
                $clausulaWith[] = $field['options']['model'];
            }
        }

        if (count($clausulaWith) > 0) {
            $debitos = $class::select()
                ->with($clausulaWith)
                ->where($clausulaWhere)
                ->orderBy('dtvencto', 'desc')
                ->get()
            ;
        } else {
            $debitos = $class::select()->where($clausulaWhere)->orderBy('dtvencto', 'desc');
        }

        if ($request->input('proprietario_id') && '00' != $request->input('proprietario_id')) {
            $filtered = [];
            foreach ($debitos as $debito) {
                if ($debito->unidade->proprietario_id == $request->input('proprietario_id')) {
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }

        if ($request->input('envio_boleto') && 'Todos' != $request->input('envio_boleto')) {
            $filtered = [];
            foreach ($debitos as $debito) {
                if ($debito->unidade->envio_boleto == $request->input('envio_boleto') or 'Ambos' == $debito->unidade->envio_boleto) {
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }

        return DataTables::of($debitos)
            ->addColumn('valor_atualizado', function ($model) {
                return $model->valoratual;
            })
            ->addColumn('action', function ($model) {
                if (null == $this->actions) {
                    $btedit = '<button class="btn edit" id="'.$model->id.'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>';
                    $btdelt = '<button class="btn delt" id="'.$model->id.'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>';

                    return '<div align="center">'.$btedit.'<span> </span>'.$btdelt.'</div>';
                }

                $text = '<div align="center">';
                foreach ($this->actions as $action) {
                    $text .= $action['ini'].$model->id.$action['fim'];
                }
                $text .= '</div>';

                return $text;
            })
            ->make(true)
        ;
    }

    public function fetchData(Request $request, $model)
    {
        $class = config('crud.'.$model);
        $id = $request->input('id');
        $item = $class::find($id);
        echo json_encode($item);
    }

    public function postData(Request $request, $model)
    {
        $class = config('crud.'.$model);
        if ('delete' == $request->get('button_action')) {
            $id = $request->input('id');

            $deleted = $class::destroy($id);
            if ($deleted) {
                $error_array = [];
                $success_output = '<div class="alert alert-success">Data Deleted</div>';
            } else {
                $success_output = '<div class="alert alert-danger">Data Deleted</div>';
                $error_array = [];
            }
        } else {
            $rules = $class::getRules();
            $validation = Validator::make($request->all(), $class::getRules());
            $error_array = [];
            $success_output = '';
            if ($validation->fails()) {
                foreach ($validation->errors()->getMessages() as $field_name => $messages) {
                    $error_array[] = $messages;
                }
            } else {
                if ('insert' == $request->get('button_action')) {
                    $item = new $class();
                    $input = $request->only($item->fillable);
                    $item->fill($input);
                    $item->save();
                    $success_output = '<div class="alert alert-success">Data Inserted</div>';
                }

                if ('update' == $request->get('button_action')) {
                    $item = $class::find($request->get('id'));
                    $input = $request->only($item->fillable);
                    $item->fill($input);
                    $item->save();
                    $success_output = '<div class="alert alert-success">Data Updated</div>';
                }
            }
        }

        $output = [
            'error' => $error_array,
            'success' => $success_output,
            'eu' => 'Mauricio Amorim',
        ];
        echo json_encode($output);
    }
}
