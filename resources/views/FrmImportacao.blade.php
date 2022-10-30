@extends('adminlte::page')

@section('title', 'Condominio')

@section('content_header')
    <h1>Importacao</h1>
@stop

@section('content')


<form method="post" action="{{ route('importacao') }}" enctype="multipart/form-data" class="dropzone" id="my-dropzone-importacao">
    {{ csrf_field() }}
    <div class="dz-message">
        <div class="col-xs-8">
            <div class="message">
                <p>Solte o arquivo aqui ou clique para selecioná-lo</p>
            </div>
        </div>
    </div>
    <div class="fallback">
        <input type="file" name="file" multiple>
    </div>
</form>
<div class="row">
    <div class="col-sm-10 offset-sm-1">
    </div>
</div>

<div class="row">
    <div class="col-sm-12 offset-sm-1">
        <textarea class="form-control"  id="textoRetorno" rows="12">Retorno:</textarea>
    </div>
</div>

@include('partials.modalConfirmacao')
@stop
@section('js')
<script>
    Dropzone.autoDiscover = false;

$("#my-dropzone-importacao").dropzone({
    url: "{{ route('importacao') }}",
    success : function(file, response){
        console.log(file);
        console.log(response);
        document.getElementById("textoRetorno").value = response;
    }
});
</script>
@stop


