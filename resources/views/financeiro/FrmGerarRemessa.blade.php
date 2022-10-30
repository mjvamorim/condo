@extends('adminlte::page')

@section('title', 'Condominio')

@section('content_header')
    <h1>Gerar Remessa</h1>
@stop


@section('content')


<form class="form-horizontal" id="formulario" method="post" action="/financeiro/gerarRemessa"  >
    <fieldset>
        {{csrf_field()}}

        <!-- Button (Double) -->
        <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
            <a href="/home" id="submit" class="btn btn-default success">Cancelar</a>
            <a href="" id="submit" class="btn btn-primary success" data-toggle="modal" data-target="#modalConfirmacao">Gerar Remessa</a>
         </div>
        </div>

    </fieldset> 
</form>

@include('partials.modalConfirmacao')


@stop




