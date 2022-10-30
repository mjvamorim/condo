@extends('adminlte::page')

@section('title', 'Condominio')

@section('content_header')
    <h1>Imprimir Boletos</h1>
@stop


@section('content')


<form class="form-horizontal" id="formulario" method="post" action="/financeiro/imprimirBoletos" >
    <fieldset>
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Ano/Mês</label>
            <div class="col-md-4">
                <select class="custom-select" name="taxa_id" id="taxa_id" >
                    <option value="00"> Todos </option>
                    @foreach ($taxas as $taxa)
                    <option value="{{$taxa->id}}"> {{$taxa->anomes}} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Unidades</label>
            <div class="col-md-4">
                <select class="custom-select" name="unidade_id" id="unidade_id" >
                    <option value="00"> Todos </option>
                    @foreach ($unidades as $unidade)
                    <option value="{{$unidade->id}}"> {{$unidade->descricao}} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Envio de Boletos</label>
            <div class="col-md-4">
                <select class="custom-select" name="envio_boleto" id="envio_boleto" >
                    <option value="Todos"> Todos </option>
                    <option value="Impresso"> Impresso </option>
                    <option value="Email"> Email </option>

                </select>
            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
            <a href="/home" id="submit" class="btn btn-default success">Cancelar</a>
            <a href="" id="submit" class="btn btn-primary success" data-toggle="modal" data-target="#modalConfirmacao">Imprimir</a>
         </div>
        </div>

    </fieldset>
</form>

@include('partials.modalConfirmacao')


@stop




