<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Unidade;



class HomeController extends Controller
{

  public function __construct(){
  }

  public function index(Request $request){
    return view('index');
  }

  public function home(Request $request){
    if (auth()->user()->nivel >=5 )
  	  return view('home');
	else
      return redirect()->route('consulta');
  }

  public function consulta(Request $request){
    $showables  = Unidade::getShowableFields();
    $unidades = Unidade::all();
    return view('consulta',compact('showables','unidades'));
  }

}
