@extends('adminlte::page')

@section('title', 'Pegasus')
@section('content_header')
<style>


</style>

@section('content')
    {{ csrf_field() }}

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Escolha o seu plano</h3>
        </div>
        <div class="box-body no-padding">
            <table class="table table-bordered"> 
                <thead>
                    <tr class="table-primary">
                        <th>#</th>
                        <th><h5>Plano 10</h5></th>                    
                        <th><h4>Plano 100</h4></th>                    
                        <th><h3>Plano 1000</h3></th>
                    </tr>
                </thead>
                <tbody>
        

                    <tr>
                        <td>Cobrança por Boleto </td>
                        <td><span class="label label-success">Sim</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                    </tr>
                    <tr>
                        <td>Boleto por email</td>
                        <td><span class="label label-success">Sim</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                    </tr>
                    <tr>
                        <td>Acordos</td>
                        <td><span class="label label-success">Sim</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                    </tr>

                    <tr>
                        <td>Área do proprietário</td>
                        <td><span class="badge">Não</span></td>                    
                        <td><span class="badge">Não</span></td>                    
                        <td><span class="label label-success">Sim</span></td>                    
                    </tr>
                    <tr>
                        <td>Limite de Unidades</td>
                        <td><span class="badge">Até 12</span></td>                    
                        <td><span class="badge">Até 99</span></td>                    
                        <td><span class="label label-success">Ilimitado</span></td>
                    </tr>
                    <tr>
                        <td>Valor Mensal</td>
                        <td><span class="">R$ 99,00</span></td>                    
                        <td><span class="">R$ 299,00</span></td>                    
                        <td><span class="">R$ 699,00</span></td>
                    </tr>
                    <tr>
                        <td>Assine agora!</td>
                        <td><a mp-mode="dftl" href="http://mpago.la/1Hfrqq" name="MP-payButton" class="btn btn-primary">Assinar</a></td>                    
                        <td><a mp-mode="dftl" href="http://mpago.la/3AQMj9" name="MP-payButton" class="btn btn-warning">Assinar</a></td>                    
                        <td><a mp-mode="dftl" href="http://mpago.la/2GCvCi" name="MP-payButton" class="btn btn-success">Assinar</a></td>                    
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.payments.mercado-pago-button')
                
   

    

  

@stop
@section('js')
<script>

</script>
@stop

