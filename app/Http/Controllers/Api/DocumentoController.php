<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    public function index(Request $request)
    {
        if ($request->input('unidade_id') && '00' != $request->input('unidade_id')) {
            $clausulaWhere[] = ['unidade_id', $request->input('unidade_id')];
        }

        return Documento::select()->where($clausulaWhere)->orderBy('id')->get();
    }

    public function store(Request $request)
    {
        $documento = new Documento();
        $input = $request->only($documento->fillable);
        $documento->fill($input);
        $documento->save();

        return $documento;
    }

    public function show(Documento $documento)
    {
        return $documento;
    }

    public function update(Request $request, Documento $documento)
    {
        $input = $request->all();
        $input['creator_id'] = auth()->id();
        $documento->update($input);

        return $documento;
    }

    public function destroy(Documento $documento)
    {
        $documento->delete();

        return response(['message' => 'Deleted']);
    }
}
