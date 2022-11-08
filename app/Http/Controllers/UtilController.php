<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Response;
use App\Mail\SendMailFaleConosco;
use Illuminate\Support\Facades\Mail;


class UtilController extends Controller
{
    function subscribe(Request $request)
    {
        return "subscribe".$request->input('sus_email'); ;
        //return redirect()->back(); ;
    }

    function faleConosco(Request $request)
    {
        // Mail::to('mjvamorim@gmail.com')->send(new SendMailFaleConosco(
        //     $request->input('name'),
        //     $request->input('email'),
        //     $request->input('subject'),
        //     $request->input('message')
        // ));
        // $msg = 'OK';
        // return response()->json( $msg, 200);

    }

    function manual() {
        $manual = public_path('pdf/Manual_ECondominio.pdf');
        return response()->download($manual);
    }

    function planilha() {
        $file = public_path('doc/condominio-importacao.xlsx');
        return response()->download($file);
    }

    function getlog() {
        $file_name = 'Log-Retorno-'.auth()->user()->empresa->id .'.txt';
        if (!Storage::exists($file_name)) {
            Storage::put($file_name,'');
        }
        $logcontent = Storage::get($file_name);
        return view('utils.FrmLogs',compact('logcontent'));
    }

    function logfile() {
        $file_name = 'Log-Retorno-'.auth()->user()->empresa->id .'.txt';
        if (!Storage::exists($file_name)) {
            Storage::put($file_name,'');
        }
        $logcontent = Storage::get($file_name);
        return response()->json( $logcontent, 200);
    }

    function savelog(Request $request) {
        $file_name = 'Log-Retorno-'.auth()->user()->empresa->id .'.txt';
        $logcontent = $request->input('log');
        Storage::put($file_name,$logcontent);
        $msg = 'OK';
        return response()->json( $msg, 200);

    }
}
