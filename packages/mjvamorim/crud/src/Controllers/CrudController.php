<?php

namespace Amorim\Crud\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use DataTables;


class CrudController extends Controller
{   

    private $actions;

    public function __construct()
    {
        $this->middleware('tenant');
    }

    function index($model,Request $request)
    {
        $class = config('crud.'.$model);
        if (class_exists($class)) {
            $filtro = $request->getQueryString();
            $showables  = $class::getShowableFields();
            return view('crud::crudview',compact('showables','model','filtro'));
        }
  
        return redirect('/admin'); 
    }

    function getData($model,Request $request)
    {
        $class = config('crud.'.$model);
        $showables  = $class::getShowableFields();
        $this->actions    = $class::getActions();
        $clausulaWith = [];
        $clausulaWhere = [['id','>','0']];
        if ($model=='estado') {
            $clausulaWhere = [['UF','>','']];
        }
       
        foreach ($showables as $field) {
            if (($field['type']=='fk') && ($field['datatable']=='true')) {
                $clausulaWith[] = $field['options']['model'];
            }
        }
        if (auth()->user()->type=='User'){
            if($model=='user'){
                $clausulaWhere[] = ['empresa_id',auth()->user()->empresa_id];
            }
            if($model=='empresa'){
                $clausulaWhere[] = ['id',auth()->user()->empresa_id];
            }
        }

        $url = $request->getQueryString();
        foreach (explode('&', $url) as $chunk) {
            $param = explode("=", $chunk);
            if ($param && $param[0]=='proprietario_id') {
                $clausulaWhere[] =  ['proprietario_id', urldecode($param[1])];
            }
            if ($param && $param[0]=='id') {
                $clausulaWhere[] =  ['id', urldecode($param[1])];
            }
            if ($param && $param[0]=='unidade_id') {
                $clausulaWhere[] =  ['unidade_id',  urldecode($param[1])];
            }
            if ($param && $param[0]=='user_id') {
                $clausulaWhere[] =  ['user_id', urldecode($param[1])];
            }
            if ($param && $param[0]=='empresa_id') {
                $clausulaWhere[] =  ['empresa_id',  urldecode($param[1])];
            }
        }

        if (count($clausulaWith)>0) {
            $collection = $class::select()
            ->with($clausulaWith)
            ->where($clausulaWhere)
            ->get();
        } else {
            $collection = $class::select()->where($clausulaWhere);
        }


        
        return DataTables::of($collection)
            ->addColumn('action', function($model){
                if($this->actions == NULL) {
                    $btedit = '<button class="btn edit" id="'.$model->id.'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>';
                    $btdelt = '<button class="btn delt" id="'.$model->id.'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>';
                    return '<div align="center">'.$btedit.'<span> </span>'.$btdelt.'</div>';
                }
                else {
                    $text = '<div align="center">';
                    foreach($this->actions as $action){
                        isset($action['campo']) ? $x =  $action['campo'] : $x = 'id';
                        $text .= $action['ini'].$model->$x.$action['fim'];
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
