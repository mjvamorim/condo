<?php

namespace App\Http\Controllers\Api;

use App\Models\Proprietario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProprietarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('tenant');
    }
    public function index()
    {

        $proprietarios = Proprietario::all();

        return $proprietarios;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proprietario = new Proprietario;
        $input =  $request->only($proprietario->fillable);
        $proprietario->fill($input);
        $proprietario->save();      
        return $proprietario;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function show(Proprietario $proprietario)
    {
        return $proprietario;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proprietario $proprietario)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();

        $proprietario->update($input);

        return $proprietario;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proprietario $proprietario)
    {
        $proprietario->delete();

        return response(['message'=>'Deleted']);
    }
}
