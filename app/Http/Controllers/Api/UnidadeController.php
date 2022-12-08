<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    public function index()
    {
        return Unidade::all();
    }

    public function store(Request $request)
    {
        $unidade = new Unidade();
        $input = $request->only($unidade->fillable);
        $unidade->fill($input);
        $unidade->save();

        return $unidade;
    }

    public function show(Unidade $unidade)
    {
        return $unidade;
    }

    public function update(Request $request, Unidade $unidade)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();

        $unidade->update($input);

        return $unidade;
    }

    public function destroy(Unidade $unidade)
    {
        $unidade->delete();

        return response(['message' => 'Deleted']);
    }
}
