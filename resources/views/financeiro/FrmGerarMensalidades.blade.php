@extends('adminlte::page')

@section('title', 'Condominio')

@section('content_header')
    <h1>Gerar Mensalidades</h1>
@stop

@section('content')

<form class="form-horizontal" id="formulario" method="post" action="/financeiro/gerarMensalidades" >

    <fieldset>
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Ano/Mes</label>
            <div class="col-md-4">
                <select class="custom-select" name="taxa_id" id="taxa_id" >
                    @foreach ($taxas as $taxa)
                    <option value="{{$taxa->id}}"> {{$taxa->anomes}} </option>
                    @endforeach              
                </select>
            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
            <a href="/home" id="submit" class="btn btn-default success">Cancelar</a>
            <a href="" id="submit" class="btn btn-primary success" data-toggle="modal" data-target="#modalConfirmacao">Gerar</a>
        </div>
        </div>

    </fieldset> 
</form>

@include('partials.modalConfirmacao')

@stop