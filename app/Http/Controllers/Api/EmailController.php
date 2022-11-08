<?php

namespace App\Http\Controllers\Api;

use App\Models\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{

    public function __construct()
    {
        $this->middleware('tenant');
    }
    public function index()
    {

        $emails = Email::all();

        return $emails;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = new Email;
        $input =  $request->only($email->fillable);
        $email->fill($input);
        $email->save();
        return $email;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return $email;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();

        $email->update($input);

        return $email;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        $email->delete();

        return response(['message'=>'Deleted']);
    }
}
