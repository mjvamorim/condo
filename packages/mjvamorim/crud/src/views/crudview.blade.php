@extends('adminlte::page')

@section('title', 'Pegasus')


@section('content_header')

@stop


@section('content')
    {{-- List of model --}}
    {{ csrf_field() }}
    <?php 
    
    $index = 'crud/'.$model;
    $fetch = 'crud/fetchdata/'.$model;
    $post  = 'crud/postdata/'.$model;
    $get   = 'crud/getdata/'.$model.'?'.$filtro;
    
    ?>
     @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            @if(is_array(session()->get('success')))
            <ul>
                @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
            @else
                {{ session()->get('success') }}
            @endif
        </div>
    @endif


    <div class="box box-sucess">
        <div class="box-header">
            <h3 class="box-title">{{ucwords($model)}} </h3>
            <div align="right">
                <button name="add" id="add_data" class="edit-modal btn glyphicon glyphicon-plus-sign" title="Cadastrar novo item" data-toggle="tooltip"  > </button> 
            </div>
        </div>    

        <div class="box-body">
            <div class="box-body table-responsive no-padding">
                <table id="dataTable" class="table table-hover table-bordered" >
                    <thead>
                        <tr>
                            @foreach ($showables as $field)
                            @if($field['datatable']=='true') 
                            <th>{{$field['title']}}</th>
                            @endif
                            @endforeach
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    
               </table>
           </div>
       </div>
    </div>

    {{-- Modal Form --}}

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="formdata">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Data</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div id="formfields">
                            @foreach ($showables as $field)
                            @if($field['form']=='true') 
                            <div id="form_input" class="row" style="margin-bottom: 10px;"> 

                                @if($field['type']=='text') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <input class="form-control" type="text" name="{{$field['name']}}" id="{{$field['name']}}" 
                                    @isset($field['mask']) 
                                       onkeypress="$(this).mask('{{$field['mask']}}');"
                                    @endisset
                                    />
                                </div>
                                @endif

                                @if($field['type']=='textarea') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <textarea class="form-control"  name="{{$field['name']}}" id="{{$field['name']}}" rows="3"></textarea>
                                </div>
                                @endif

                                @if($field['type']=='date') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <input class="form-control" type="date" name="{{$field['name']}}" id="{{$field['name']}}"/>
                                </div>
                                @endif

                                @if($field['type']=='datetime') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <input class="form-control" type="datetime" name="{{$field['name']}}" id="{{$field['name']}}"/>
                                </div>
                                @endif


                                @if($field['type']=='money') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <input class="form-control text-left" type="number" step="0.01" id="{{$field['name']}}" name="{{$field['name']}}"  >
                                    
                                </div>
                                @endif

                                @if($field['type']=='number') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <input class="form-control text-left" type="number" step="{{$field['step']}}" id="{{$field['name']}}" name="{{$field['name']}}"  >
                                    
                                </div>
                                @endif
                              
                                @if($field['type']=='cep') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <input class="form-control" type="text" name="{{$field['name']}}" 
                                        id="{{$field['name']}}" size="10" maxlength="9" 
                                        onblur="pesquisacep(this.value);" 
                                    @isset($field['mask']) 
                                    onkeypress="$(this).mask('{{$field['mask']}}');"   
                                    @endisset
                                    />
                                </div>
                                @endif        

                                @if($field['type']=='select') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <select class="custom-select" name="{{$field['name']}}" id="{{$field['name']}}" >
                                    @foreach ($field['options'] as $option)
                                    <option value="{{$option['value']}}"> {{$option['label']}}</option>
                                    @endforeach              
                                    </select>
                                </div>
                                @endif         

                                @if($field['type']=='radio') 
                                    <div class= "col-md-2">
                                        <label>{{$field['title']}}</label>
                                    </div>
                                    <div class= "col-md-{{$field['size']}}">   
                                    @foreach ($field['options'] as $option)
                                        <br/>
                                        <input class="form-check-input" type="radio" name="{{$field['name']}}" id="{{$field['name']}}" value="{{$option['value']}}">
                                        <label > {{$option['label']}}</label>
                                    @endforeach     
                                    </div>         
                                @endif      

                                @if($field['type']=='fk') 
                                <div class= "col-md-2">
                                    <label>{{$field['title']}}</label>
                                </div>
                                <div class= "col-md-{{$field['size']}}">   
                                    <select class="custom-select" name="{{$field['name']}}" id="{{$field['name']}}" >
                                    <option></option>
                                    </select>
                                </div>
                                <div id="mensagem">
             
                                 </div>
                                @endif                

                            </div>
                            @endif
                            @endforeach
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" value="" />
                        <input type="hidden" name="button_action" id="button_action" value="insert" />
                        <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

@stop
@section('js')
<script>
$(document).ready(function() {

    

    //Carregar no onload da página
    @foreach ($showables as $field)
    @if($field['type']=='fk') 
        var url = "/crud/getdata/{{$field['options']['model']}}";
        $.ajax({
            url: url,
            method:'get',
            dataType:'json',
            success:function(data)
            {
                var option = '<option></option>';
                for(var i = 0; i < data.recordsTotal; i++)
                {
                    option += '<option value="'+data.data[i].{{$field['options']['value']}}+'">'+data.data[i].{{$field['options']['label']}}+'</option>';
                }
                $('#{{$field['name']}}').html(option).show();
           }
        })  
        
    @endif
    @endforeach
    

    function sortList(id) { 
        var lb = document.getElementById(id); 
        arrTexts = new Array(); 
        arrValues = new Array(); 
        arrOldTexts = new Array(); 

        for(i=0; i<lb.length; i++) { 
            arrTexts[i] = lb.options[i].text; 
            arrValues[i] = lb.options[i].value; 
            arrOldTexts[i] = lb.options[i].text; 
        } 

        arrTexts.sort(); 

        for(i=0; i<lb.length; i++) { 
            lb.options[i].text = arrTexts[i]; 
            for(j=0; j<lb.length; j++) { 
                if (arrTexts[i] == arrOldTexts[j]) { 
                    lb.options[i].value = arrValues[j]; 
                    j = lb.length; 
                } 
            } 
        } 
    } 

    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "dom": 'Bfrtip',
        "buttons": ['copy', 'csv', 'excel', 'pdf'], 
        "paging": false,
        "ajax": "{{ url($get) }}",
        "columns":[
            @foreach ($showables as $field)
                @if($field['datatable']=='true') 
                    @switch($field['type'])
                    @case('money')
                        { "data": "{{$field['name']}}" ,render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' )},
                        @break
                    @case('number')
                        <?php $x = strlen(strstr($field['step'],'.'))-1; ?>
                        { "data": "{{$field['name']}}" ,render: $.fn.dataTable.render.number( '.', ',', {{$x}}, '' )},
                        @break
                    @case('fk')
                        { "data": "{{$field['options']['model']}}.{{$field['options']['label']}}" },
                        @break;
                    @default
                        { "data": "{{$field['name']}}" },
                    @endswitch
              @endif
            @endforeach
            { "data": "action", orderable:false, searchable: false}
        ]    
    });

    $('#add_data').click(function(){
        //Ordena os campos dos combobox 
        @foreach ($showables as $field)
        @if($field['type']=='fk') 
        sortList('{{$field['name']}}');
        @endif
        @endforeach

        $('#formModal').modal('show');
        $('#formdata')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('insert');
        $('#action').val('Add');
        $('#id').val('0');
        $('#formfields').show();
        $('.modal-title').text('Add Data');
    });

    $(document).on('click', '.edit', function(){
        //Ordena os campos dos combobox 
        @foreach ($showables as $field)
        @if($field['type']=='fk') 
        sortList('{{$field['name']}}');
        @endif
        @endforeach

        var id = $(this).attr("id");
        $('#form_output').html('');
        $('#formfields').show();
        $.ajax({
            url:"{{url($fetch)}}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                //Coloca os valores nos formulario
                @foreach ($showables as $field)
                @if($field['form']=='true') 
                $('#{{$field["name"]}}').val(data.{{$field["name"]}});
                @endif
                @if($field['type']=='money') 
                //$('#{{$field["name"]}}').maskMoney('destroy');
                //$('#{{$field["name"]}}').maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:'.', affixesStay: true},data.{{$field["name"]}});
                @endif

                @endforeach

                $('#id').val(id);
                $('#formModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
                $('#button_action').val('update');
            }
        })
    });


    $(document).on('click', '.delt', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $('#formfields').hide();
        
        $.ajax({
            url:"{{url($fetch)}}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#name').val(data.name);
                $('#id').val(id);
                $('#formModal').modal('show');
                $('#action').val('Delete');
                $('.modal-title').text('Delete :'+data.name+'?');
                $('#button_action').val('delete');
            }
        })
    });

   
    $('#formdata').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ url($post) }}",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
                if(data.error.length > 0)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                    }
                    $('#form_output').html(error_html);
                }
                else
                {
                    $('#formModal').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                }
            }
        })
    });

    $(document).on('click', '.slct', function(){
        var id = $(this).attr("id");
              
        $.ajax({
            url:"empresa/"+id,
            method:'get',
            dataType:'json',
            success:function(data)
            {
                window.location ="{{ url($index) }}";

            }
        })
    })


});
</script>
@stop

