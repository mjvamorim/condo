<?php

namespace App\Http\Controllers;

use App\User;
use Amorim\Upload\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Validator;
use Response;
use DataTables;
use Auth;

class UserController extends Controller
{   
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/img/users/');
    }

    function index(Request $request)
    {
        $showables  = User::getShowableFields();
        $model = 'user';
        $filtro = $request->getQueryString();
        return view('crud::crudview',compact('showables','model','filtro'));
    }

    // function getData()
    // {
  
    //     $users = User::select();
    //     return DataTables::of($users)
    //         ->addColumn('action', function($user){
    //             $btedit = '<button class="btn edit" id="'.$user->id.'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>';
    //             $btdelt = '<button class="btn delt" id="'.$user->id.'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>';
    //             return '<div align="center">'.$btedit.'<span> </span>'.$btdelt.'</div>';
    //         })
    //         ->make(true);
    // }

    // function fetchData(Request $request,User $user )
    // {
    //     $id = $request->input('id');
    //     $user = User::find($id);
    //     echo json_encode($user);
    // }


    // function postData(Request $request)
    // {
    //     if($request->get('button_action') == 'delete')
    //     {
    //         $id = $request->input('id');

    //         $deleted = User::destroy($id);
    //         if ($deleted) {
    //             $error_array = [];
    //             $success_output = '<div class="alert alert-success">Data Deleted</div>';
    //         } else {
    //             $success_output = '<div class="alert alert-danger">Data Deleted</div>';
    //             $error_array = [];
    //         }

    //     }
    //     else {

    //         $rules = User::getRules();
    //         $validation = Validator::make($request->all(), User::getRules());      
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
    //                 $user = new User;
    //                 $input =  $request->only($user->fillable);
    //                 $user->fill($input);
    //                 $user->save();
    //                 $success_output = '<div class="alert alert-success">Data Inserted</div>';
    //             }

    //             if($request->get('button_action') == 'update')
    //             {
    //                 $user = User::find($request->get('id'));
    //                 $input =  $request->only($user->fillable);
    //                 $user->fill($input);
    //                 $user->save();
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

    public function storeUserPhoto(Request $request)
    {
        $photos = $request->file('file');
 
        if (!is_array($photos)) {
            $photos = [$photos];
        }
 
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }
 
        $photo = $photos[0];
        $name = sha1(date('YmdHis') . str_random(30));
        $save_name = $name . '.' . $photo->getClientOriginalExtension();
        $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

        Image::make($photo)
            ->resize(250, null, function ($constraints) {
                $constraints->aspectRatio();
            })
            ->save($this->photos_path . '/' . $resize_name);

        $photo->move($this->photos_path, $save_name);

        $upload = new Upload();
        $upload->filename = $save_name;
        $upload->resized_name = $resize_name;
        $upload->original_name = basename($photo->getClientOriginalName());
        $upload->save();
        
        $user = User::find(Auth::user()->id);
        $user->image = $upload->resized_name;
        $user->save();

        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }
 

}
