@extends('adminlte::page')

@section('title', 'Pegasus')


@section('content_header')

@stop


@section('content')
    {{-- List of model --}}
    {{ csrf_field() }}
    @php($index = 'debitos')

    @php($fetch = 'crud/fetchdata/debito')
    @php($post  = 'crud/postdata/debito')
    @php($get   = 'crud/getdata/debito')
    @php($email_url='financeiro/emailBoletos')
    @php($boleto_impresso_url='financeiro/imprimirBoletos')
    @php($listagemDebitos_url='financeiro/listagemDebitos')

    <div class="box ">
        <div class="box-header">
            <h3 class="box-title">Debitos:</h3>
            <div align="right">
                <button name="add" id="add_data" class="edit-modal btn glyphicon glyphicon-plus-sign" title="Cadastrar novo item" data-toggle="tooltip"  > </button>
            </div>

            <form id="formulario" method="get" action="debitos"  >
                <fieldset>
                    <div class="form-group row">
                        <div class="col-sm-1">
                            <label  for="proprietario_id">Proprietarios:</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="custom-select" name="proprietario_id" id="proprietario_id" >
                                <option value="00"> Todos os proprietarios</option>
                                @foreach ($proprietarios as $proprietario)
                                <option value="{{$proprietario->id}}"
                                    @if($proprietario->id==$proprietario_id)
                                    selected="selected"
                                    @endif
                                > {{$proprietario->nome}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <label  for="unidade_id">Unidade:</label>
                        </div>
                        <div class="col-sm-2">

                            <select class="custom-select" name="unidade_id" id="unidade_id_filtro" >
                                <option value="00"> Todas as Unidades</option>
                                @foreach ($unidades as $unidade)
                                <option value="{{$unidade->id}}"
                                    @if($unidade->id==$unidade_id)
                                    selected="selected"
                                    @endif
                                > {{$unidade->descricao}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <label  for="tipo_id">Tipo Débito:</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="custom-select" name="tipo_id" id="tipo_id" >
                                <option value="Todos"> Todos </option>
                                <option value="Avulso"> Avulso </option>
                                <option value="Mensalidade"> Mensalidade </option>
                                <option value="Acordo"> Acordo </option>
                                <option value="Multa"> Multa </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-sm-1">
                            <label  for="dtini">Periodo:</label>
                        </div>
                        <div class="col-sm-4">

                            <input type='date' name='dtini' id="dtini">
                                à
                            <input type='date' name='dtfim'id="dtfim">

                        </div>

                        <div class="col-sm-1">
                            <label  for="condicao">Condição:</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="custom-select" name="condicao" id="condicao" >
                                <option value="Todos"> Todos </option>
                                <option value="Abertos"> Abertos </option>
                                <option value="Pagos"> Pagos </option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <label  for="envio_boleto">Tipo Envio:</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="custom-select" name="envio_boleto" id="envio_boleto" >
                                <option value="Todos"> Todos </option>
                                <option value="Impresso"> Impresso </option>
                                <option value="Email"> Email </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-1">
                            <label  for="envio_boleto">Ordenação da Listagem:</label>
                        </div>
                        <div class="col-sm-3">
                            <select class="custom-select" name="ordem" id="ordem" >
                                <option value="Proprietario"> Proprietario </option>
                                <option value="Unidade"> Unidade </option>
                                <option value="Pagto"> Pagamento </option>
                                <option value="Vencto"> Vencimento </option>
                            </select>
                        </div>
                        <!-- Button  -->
                        <div class="col-sm-4">
                            <input type="button"  value = "Filtra" class="btn btn-primary success" onclick="datatable_sincroniza()">
                            <input type="button"  value = "Boletos Impressos" class="btn btn-default success" onclick="boletos_impressos()">
                            <input type="button"  value = "Boletos Email" class="btn btn-default success" onclick="envia_email()">
                            <input type="button"  value = "Listagem" class="btn btn-default success " onclick="listagemDebitos()"><i class=""></i>
                        </div>
                    </div>
                </fieldset>
            </form>


        </div>

        <div class="box-body">
            <div class="box-body table-responsive no-padding">
                <table id="dataTable" class="table cell-border table table-hover table-bordered compact stripe"  >
                    <thead>
                        <tr>
                            @foreach ($showables as $field)
                            @if($field['datatable']=='true')
                            <th>{{$field['title']}}</th>
                            @endif
                            @endforeach
                            <th class="text-center">Vl.Devido</th>
                            <th class="text-center">------Opções------</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            @foreach ($showables as $field)
                            @if($field['datatable']=='true')
                            <th></th>
                            @endif
                            @endforeach
                            <th class="text-center"></th>
                            <th class="text-center"></th>

                        </tr>
                    </tfoot>

               </table>
           </div>
    </div>


    {{-- Modal Form formModal--}}

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
                                    <textarea class="form-control"  name="{{$field['name']}}" id="{{$field['name']}}" rows="3">
                                    </textarea>
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

                                @if($field['type']=='hidden')
                                <input class="form-control" type="hidden" name="{{$field['name']}}" id="{{$field['name']}}"/>
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


    {{-- Modal Form ModalMessage--}}
    <div id="modalMessage" class="modal fade"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>


@stop
@section('js')
<script>
$(document).ready(function() {

    condicao = document.getElementById('condicao');
    condicao.value = 'Abertos';

    $('#unidade_id_filtro').on('change', function(){
        unidade_id = document.getElementById('unidade_id_filtro');
        condicao = document.getElementById('condicao');
    });

    $('#tipo').on('change', function(){
        habilita_tipo();
    });

    function habilita_tipo() {
        var tipo = $('#tipo').val();

        document.getElementById('taxa_id').disabled = false;
        document.getElementById('acordo_id').disabled = false;
        $('#acordo_id').disabled = false;
        switch(tipo) {
            case "Mensalidade":
                $('#acordo_id').val('');
                document.getElementById('acordo_id').disabled = true;
                break;
            case "Acordo":
                $('#taxa_id').val('');
                document.getElementById('taxa_id').disabled = true;
                break;
            default:
                $('#taxa_id').val('');
                $('#acordo_id').val('');
                document.getElementById('taxa_id').disabled = true;
                document.getElementById('acordo_id').disabled = true;

        }
    }

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

    function ordenaFormComboBox() {
        //Ordena os campos dos combobox
        @foreach ($showables as $field)
        @if($field['form']=='true' && $field['type']=='fk')
        sortList('{{$field['name']}}');
        @endif
        @isset($field['readonly'])
        document.getElementById('{{$field['name']}}').disabled = true;
        @endisset
        @endforeach

    }

    $('#add_data').click(function(){
        ordenaFormComboBox();

        document.getElementById('taxa_id').disabled = true;
        document.getElementById('acordo_id').disabled = true;

        $('#formModal').modal('show');
        $('#formdata')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('insert');
        $('#action').val('Add');
        $('#id').val('0');
        $('#formfields').show();
        $('#unidade_id').val($('#unidade_id_filtro').val());
        $('.modal-title').text('Add Data');
    });


    //-----------Ajax Edit ------------------/

    $(document).on('click', '.edit', function(){
        //Ordena os campos dos combobox
        ordenaFormComboBox();

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
                @endforeach

                $('#id').val(id);
                $('#formModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
                $('#button_action').val('update');
            }
        })
    });


    //-----------Ajax Delete ------------------/

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

    //-----------Ajax Email Único------------------/
    $(document).on('click', '.email', function(){
        var id = $(this).attr("id");
        $.ajax({
            url:"{{url($email_url)}}",
            method:'get',
            data:{debito_id:id, email:'S'},
            dataType:'json',
            success:function(data)
            {
                alert("Email enviado com sucesso.");
            },
            error: function(data) {
                var errors = data.responseJSON;
                //console.log(errors.errors);
                //errorsHtml= '<div class="alert alert-danger"><ul>';
                errorsHtml= '';
                $.each( errors.errors, function( key, value ) {
                      //errorsHtml += '<li>'+ value[0] + '</li>';
                      errorsHtml +=  value[0];
                 });
                //errorsHtml += '</ul></div>';

                alert(errorsHtml);
            }
        })
    });

    //-----------Ajax Save ------------------/

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


    //-----------Ajax Edit, Delete e Submit ----------------/

});

//window.onload = datatable_sincroniza;
//-----------Ajax Envio de Boletos por Email em Bloco----------------/
function envia_email() {

email = document.getElementById('envio_boleto');
email.value = 'Email';

var dados = $('#formulario').serialize();
$.ajax({
    url:"{{url($email_url)}}",
    method:'get',
    data:dados,
    dataType:'json',
    success:function(data)
    {
        alert("Email enviado com sucesso.");
    },
    error: function(data) {
        var errors = data.responseJSON;
        //console.log(errors.errors);
        //errorsHtml= '<div class="alert alert-danger"><ul>';
        errorsHtml= '';
        $.each( errors.errors, function( key, value ) {
                //errorsHtml += '<li>'+ value[0] + '</li>';
                errorsHtml +=  value[0];
            });
        //errorsHtml += '</ul></div>';

        alert(errorsHtml);
    }
})

}


//-----------Ajax Envio de Boletos Impressos em Bloco----------------/
function boletos_impressos() {

    email = document.getElementById('envio_boleto');
    //email.value = 'Impresso';

    var dados = $('#formulario').serialize();
    var dados = $('#formulario').serialize();
    url = "{{url($boleto_impresso_url)}}";
    url = url + '?' + dados
    window.open(url, '_blank');


    // $.ajax({
    //     url:"{{url($boleto_impresso_url)}}",
    //     method:'get',
    //     data:dados,
    //     dataType:'json',
    //     success:function(data)
    //     {
    //         alert("Email enviado com sucesso.");
    //     },
    //     error: function(data) {
    //         var errors = data.responseJSON;
    //         //console.log(errors.errors);
    //         //errorsHtml= '<div class="alert alert-danger"><ul>';
    //         errorsHtml= '';
    //         $.each( errors.errors, function( key, value ) {
    //                 //errorsHtml += '<li>'+ value[0] + '</li>';
    //                 errorsHtml +=  value[0];
    //             });
    //         //errorsHtml += '</ul></div>';

    //         alert(errorsHtml);
    //     }
    // })

}

//-----------Ajax listagemDebitos ----------------/
function listagemDebitos() {

    var dados = $('#formulario').serialize();
    url = "{{url($listagemDebitos_url)}}";
    url = url + '?' + dados
    window.open(url, '_blank');
}


//-----------Ajax DataTable Sincroniza ----------------/
function datatable_sincroniza() {

    unidade_id = document.getElementById('unidade_id');
    condicao = document.getElementById('condicao');

    if (unidade_id.value=='' && condicao.value == 'Todos') {
        condicao.value = 'Abertos';
    }



    if ( $.fn.dataTable.isDataTable( '#dataTable' ) ) {
        $('#dataTable').dataTable().fnClearTable();
        $('#dataTable').dataTable().fnDestroy();
    }
    var dados = $('#formulario').serialize();
    console.log(dados);
    var table = $('#dataTable').DataTable({
        fixedHeader: {
            header: true,
            footer: true
        },
        "processing": true,
        "serverSide": false,
        "dom": 'Bfrtip',
        "buttons": ['copy', 'csv', 'excel', 'pdf'],
        "paging": false,
        "ajax": {
            "url": "debitos/getdata?"+dados
        } ,
        "columns":[
            @foreach ($showables as $field)
                @if($field['datatable']=='true')
                    @switch($field['type'])
                    @case('money')
                        { "data": "{{$field['name']}}" ,render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ), orderable:false, searchable: false},
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
            { "data": "valor_atualizado" ,render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ), orderable:false, searchable: false},
            { "data": "action", orderable:false, searchable: false}

        ] ,
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                console.log('enter1');
                return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1
                : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            total = api.column( 7 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api.column( 7, { page: 'current'} ).data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 7 ).footer() ).html( 'R$'+ total.toFixed(2)  );
        }
    });

    var table = $('#dataTable').DataTable();
    var sum = table.column(6).data().sum();
    $('#total7').val(sum);



}
</script>
@stop

