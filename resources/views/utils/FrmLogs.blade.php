@extends('adminlte::page')

@section('title', 'Condominio')

@section('content_header')
    <h1>Logs</h1>
@stop

@section('content')
<div align="left">
    <button name="add" id="add_data" class="edit-modal btn glyphicon glyphicon-floppy-disk" onclick="grava_log()" title="Gravar Log" data-toggle="tooltip"  > </button>
</div>

<div class="row">
    <div class="col-sm-12 offset-sm-1">
    <textarea class="form-control"  id="log" name='log' rows="60">{{$logcontent}}</textarea>
    </div>
</div>

@stop
@section('js')
<script>
function grava_log() {

    var log = $('#log').val();
    $.ajax({
        url:"/log/save",
        method:'post',
        data:{
            'log' : log,
            "_token": "{{ csrf_token() }}",
        }
        ,
        dataType:'json',
        success:function(data)
        {
            alert("Log Gravado.");
        },
        error: function(data) {
            alert("Problema na gravação do Log.");
        }
    })
}
</script>
@stop


