<?php

namespace App\Http\Controllers\Api;

use App\Models\Taxa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxaController extends Controller
{

    public function __construct()
    {
        $this->middleware('tenant');
    }
    public function index()
    {

        $taxas = Taxa::all();

        return $taxas;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taxa = new Taxa;
        $input =  $request->only($taxa->fillable);
        $taxa->fill($input);
        $taxa->save();
        return $taxa;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Taxa  $taxa
     * @return \Illuminate\Http\Response
     */
    public function show(Taxa $taxa)
    {
        return $taxa;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Taxa  $taxa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taxa $taxa)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();

        $taxa->update($input);

        return $taxa;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxa  $taxa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxa $taxa)
    {
        $taxa->delete();

        return response(['message'=>'Deleted']);
    }
}
