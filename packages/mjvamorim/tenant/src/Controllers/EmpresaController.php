<?php

namespace Amorim\Tenant\Controllers;

use Amorim\Tenant\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use DataTables;


class EmpresaController extends Controller
{   

    function index()
    {
        $showables  = Empresa::getShowableFields();
        $model = 'empresa';
        return view('crud::crudview',compact('showables','model'));
        
    }

    // function getData()
    // {
    //     $empresas = Empresa::select();
    //     return DataTables::of($empresas)
    //         ->addColumn('action', function($empresa){
    //             $btedit = '<button class="btn edit" id="'.$empresa->id.'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>';
    //             $btdelt = '<button class="btn delt" id="'.$empresa->id.'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>';
    //             $btslct = '<button class="btn slct" id="'.$empresa->id.'" title="Escolher" data-toggle="tooltip" ><i class="glyphicon glyphicon-folder-open"></i> </button>';
    //             return '<div align="center">'.$btedit.'<span> </span>'.$btdelt.'<span> </span>'.$btslct.'</div>';
    //         })
    //         ->make(true);
    // }

    // function fetchData(Request $request,Empresa $empresa )
    // {
    //     $id = $request->input('id');
    //     $empresa = Empresa::find($id);
    //     echo json_encode($empresa);
    // }


    // function postData(Request $request)
    // {
    //     if($request->get('button_action') == 'delete')
    //     {
    //         $id = $request->input('id');

    //         $deleted = Empresa::destroy($id);
    //         if ($deleted) {
    //             $error_array = [];
    //             $success_output = '<div class="alert alert-success">Data Deleted</div>';
    //         } else {
    //             $success_output = '<div class="alert alert-danger">Data Deleted</div>';
    //             $error_array = [];
    //         }

    //     }
    //     else {

    //         $rules = Empresa::getRules();
    //         $validation = Validator::make($request->all(), Empresa::getRules());      
    //         $error_array = array();
    //         $success_output = '';
    //         if ($validation->fails())
    //         {
    //             foreach ($validation->messages()->getMessages() as $field_name => $messages)
    //             {
    //                 $error_array[] = $messages; 
    //             }
    //         }
    //         else
    //         {
    //             if($request->get('button_action') == 'insert')
    //             {
    //                 $empresa = new Empresa;
    //                 $input =  $request->only($empresa->fillable);
    //                 $empresa->fill($input);
    //                 $empresa->save();
    //                 $success_output = '<div class="alert alert-success">Data Inserted</div>';
    //             }

    //             if($request->get('button_action') == 'update')
    //             {
    //                 $empresa = Empresa::find($request->get('id'));
    //                 $input =  $request->only($empresa->fillable);
    //                 $empresa->fill($input);
    //                 $empresa->save();
    //                 $success_output = '<div class="alert alert-success">Data Updated</div>';
    //             }
    //         }
    //     }
            
    //     $output = array(
    //         'error'     =>  $error_array,
    //         'success'   =>  $success_output,
    //         'eu'        => 'Mauricio Amorim',
    //     );
    //     echo json_encode($output);
    // }
}

