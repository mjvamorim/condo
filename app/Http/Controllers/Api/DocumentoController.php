<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Auth;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    private $documentos_path;

    public function __construct()
    {
        $this->middleware('tenant');
        $this->documentos_path = storage_path('documentos');
        if (!is_dir($this->documentos_path)) {
            mkdir($this->documentos_path, 0777);
        }
    }

    public function index(Request $request)
    {
        $clausulaWhere = [];
        if ($request->input('unidade_id') && '00' != $request->input('unidade_id')) {
            $clausulaWhere[] = ['unidade_id', $request->input('unidade_id')];
        }

        return Documento::select()->where($clausulaWhere)->orderBy('id')->get();
    }

    public function store(Request $request)
    {
        // Insere documento para obter o id
        $documento = new Documento();
        $input = $request->only($documento->fillable);
        $documento->fill($input);
        $documento->arquivo = 'arquivo.pdf';
        $documento->save();

        // Faz upload do arquivo
        $arquivo = $request->file('arquivo');
        $arquivo_extensao = $arquivo->getClientOriginalExtension();
        $arquivo_nome =
            str_pad(Auth::user()->empresa->id, 3, '0', STR_PAD_LEFT)
            .'-'.str_pad($documento->id, 5, '0', STR_PAD_LEFT)
            .'.'.$arquivo_extensao;
        $arquivo->move($this->documentos_path, $arquivo_nome);

        // Regrava documento com o nome do arquivo atualizado
        $documento->arquivo = $arquivo_nome;
        $documento->update();

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

    public function download($id)
    {
        $documento = Documento::find($id);
        $arquivo_nome_completo = $this->documentos_path.DIRECTORY_SEPARATOR.$documento->arquivo;

        return response()->download($arquivo_nome_completo);
    }
}
