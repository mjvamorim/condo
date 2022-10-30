<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Acordo;
use App\Models\Unidade;
use App\Models\Proprietario;
use Validator;
use Response;
use DataTables;
use \DB;


class AcordoController extends Controller
{

    private $actions;

    public function __construct()
    {
        $this->middleware('tenant');
    }

    function index(Request $request)
    {
        $showables  = Acordo::getShowableFields();
        return view('FrmAcordos',compact('showables','acordos'));
    }

     //-------------------------clausulaWhere-------------------------------//
     public static function clausulaWhere(Request $request) {
        $clausulaWhere = [];
        if ($request->input('acordo_id') && $request->input('acordo_id')!='0') {
            $clausulaWhere[] = ['acordo_id',$request->input('acordo_id')];
        }
        if ($request->input('acordo_id') && $request->input('acordo_id')!='0') {
            $clausulaWhere[] = ['id',$request->input('acordo_id')];
        }
       return $clausulaWhere;

    }

    function getData(Request $request)
    {
        $model = 'acordo';
        $clausulaWhere = $this->clausulaWhere($request);

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
            $acordos = $class::select()
            ->with($clausulaWith)
            ->where($clausulaWhere)
            ->orderBy('id','asc')
            ->get();
        }
        else {
            $acordos = $class::select()->where($clausulaWhere)->orderBy('id','asc');
        }

        if ($request->input('proprietario_id') && $request->input('proprietario_id')!='00') {
            $filtered = [];
            foreach($acordos as $acordo){
                if($acordo->unidade->proprietario_id == $request->input('proprietario_id') ){
                    $filtered[] = $acordo;
                }
            }
            $acordos = collect($filtered);
        }


        return DataTables::of($acordos)
            // ->addColumn('valor_atualizado', function($model){
            //     return $model->valoratual;
            // })
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
