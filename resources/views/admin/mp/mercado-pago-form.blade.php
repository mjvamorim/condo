@extends('adminlte::adminlte')

@section('title', 'Condominio')


@section('content_header')
<style>
    .creditcard-box {
        width: 450px;
        margin: 7% auto;
    }
    .error{
        color: #c90000;
    }
</style>

@stop

@section('content')
<div class="box creditcard-box">
    <div class="box-header">
        <h3 class="box-title">Dados para Pagamento</h3>
    </div>    

    <div class="register-box-body">
        <form id="form1" action={{ route("mppost") }} method="POST">
            {{ csrf_field() }}
            <!--HIDDENS-->
            <input type="hidden" name="titular_doc_tipo" data-checkout="docType" value="CPF"/>
            <input type="hidden" data-checkout="siteId" value="MLB"/>
            <input type="hidden" name="paymentMethod" value="creditcard">
            <input type="hidden" name="id" value="1">
            <input type="hidden" name="nome" value="Produto Teste">
            <input type="hidden" name="qtde" value="1">
            <input type="hidden" name="total" class="total" value="10.50">

            <input type="hidden" name="nome"  value="Teste">
            <input type="hidden" name="sobrenome"  value="Teste">
            <input type="hidden" name="email" id="email"  value="teste@teste.com">
            <input type="hidden" name="ddd" value="11">
            <input type="hidden" name="telefone" value="00000000">

            <h4>Dados do cartão:</h4>

            <div class="form-group">
                <label class="">Número do cartão:</label>
                <input type="text" name="cartao_numero" id="cartao_numero" class="form-control" data-checkout="cardNumber" autocomplete=off value="" maxlength="16">
                <div id="img_bandeira" class="col"></div>
            </div>

            <div class="form-group">
                <label class="">Validade Mês:</label>
                <select name="cartao_mes" id="cartao_mes" data-checkout="cardExpirationMonth" class="form-control">
                    <option value="">Selecione...</option>
                    @php 
                    for ($i = 1; $i <= 12; $i++) { 
                        echo "<option value='" . $i . "' " . (($i == 12) ? "selected" : "") . ">{$i}</option>";
                    }
                    @endphp
                </select>

                <label class="">Ano:</label>
                <select name="cartao_ano" id="cartao_ano" data-checkout="cardExpirationYear" class="form-control">
                    <option value="">Selecione...</option>
                    @php 
                    for ($i = date("Y"); $i <= date("Y") + 15; $i++) {
                        echo "<option value='" . $i . "' " . (($i == 2030) ? "selected" : "") . ">{$i}</option>";
                    }
                    @endphp
                </select>
            </div>

            <div class="form-group">
                <label class="">Cód. de Segurança:</label>
                <input type="text" name="cartao_codigo" id="cartao_codigo" data-checkout="securityCode" value="" class="form-control" maxlength="3">
            </div>

            <div class="form-group">
                <label class='' for="parcelamento">Parcelas:</label>
                <select id="parcelamento" name='parcelas_quantidade' class="form-control"></select>
            </div>

            <div class="form-group">
                <label class="">Nome Titular Cartão:</label>
                <input type="text" name="titular_nome" data-checkout="cardholderName" class="form-control " value="{{ isset(Auth::user()->name) ?  Auth::user()->name : ''}} " >
            </div>

            <div class="form-group ">
                <label class="">CPF:</label>
                <input type="text" name="titular_doc" data-checkout="docNumber" class="form-control cpf" value="">
            </div>

 
            <hr>

            <div class="form-group ">
                <label class="">Mensalidade:</label>
                <input type="text" name="total" class="form-control form-control-sm col-md-2 total" value="10.50" disabled>
            </div>
            <div class="form-group  float-right">
                <button type="submit" class="btn btn-success ">Pagar com Cartão</button>
            </div>
        </form>
    </div>
</div>
</div>


 
@stop


@section('js')
    <script src="{{ url('/js/jquery.js') }}"></script>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
    <script src="js/jquery.validation-meus-metodos.js"></script>
    <script>
        Mercadopago.setPublishableKey("TEST-d557d65c-5fd9-473e-bfec-2cf57051cd95");
        $(document).ready(function () {
            $("#form1").validate({
                rules: {
                    cartao_numero: {
					    required: true,
					    minlength: 16
				    },
                    cartao_mes: {required: true},
                    cartao_ano: {required: true},
                    cartao_codigo: {
					    required: true,
					    minlength: 3
				    },
                    parcelas_quantidade: {required: true}
                },

                messages: {
                    cartao_numero: {
					    required: "Digite o número do cartão de crédito.",
					    minlength: "O cartão deve ter no mínimo 16 digitos"
				    },
                    cartao_mes: "Digite o mês de validade do cartão.",
                    cartao_ano: "Digite o ano de validade do cartão.",
                    cartao_codigo: {
					    required: "Digite o código de segurança do cartão.",
					    minlength: "O cartão deve ter 3 digitos"
				    },
                    parcelas_quantidade: "Escolha uma forma de parcelamento."
                },

                submitHandler: function (form) {

                    //Get Token
                    var form = document.querySelector('#form1'); //Get form
                    Mercadopago.createToken(form, tokenHandler);
                }
            });

            //Mostra Bandeira + parcelas
            if( $("#form1 #cartao_numero") != ""){

                Mercadopago.getPaymentMethod({
                    "bin": getBin()
                }, setPaymentMethodInfo);
            }

            //Atualiza Valor total ao mudar qtd de parcelas
            $("#form1 select[name=parcelas_quantidade]").on('change', function () {

                var retorno = this.value.split("-");

                var v = retorno[1].toString();

                $(".total").val(v);
            });

            function addEvent(el, eventName, handler) {
                console.log("addEvent");
                if (el.addEventListener) {
                    el.addEventListener(eventName, handler);
                } else {
                    el.attachEvent('on' + eventName, function () {
                        handler.call(el);
                    });
                }
            };

            function tokenHandler(status, response) {
                if (status != 200 && status != 201) {
                    alert("Verifique o preenchimento dos dados");
                } else {
                    console.log("tokenHandler");
                    var form = document.querySelector('#form1');
                    //Cria um input
                    var card = document.createElement('input');
                    card.setAttribute('name', "token");
                    card.setAttribute('type', "hidden");
                    card.setAttribute('value', response.id);
                    form.appendChild(card);
                    doSubmit = true;
                    form.submit();
                }
            };

            function getBin() {
                //Número do cartão formatado
                var ccNumber = document.querySelector('#form1 input[data-checkout="cardNumber"]');
                return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
            };

            function guessingPaymentMethod(event) {
                var bin = getBin();

                if (event.type == "keyup") {
                    if (bin.length >= 6) {
                        Mercadopago.getPaymentMethod({
                            "bin": bin
                        }, setPaymentMethodInfo);
                    }
                } else {
                    setTimeout(function () {
                        if (bin.length >= 6) {
                            Mercadopago.getPaymentMethod({
                                "bin": bin
                            }, setPaymentMethodInfo);
                        }
                    }, 100);
                }
            };

            function setPaymentMethodInfo(status, response) {
                if (status == 200) {
                    //EXECUTA ALGUMAS OPERAÇÕES ESSENCIAIS PARA O PAGAMENTO COMO DETERMINAR OS DETALHES DO MEIO DE PAGAMENTO SELECIONADO COMO POR EXEMPLO BANDEIRA DO CARTÃO DE CRÉDITO
                    var form = document.querySelector('#form1');

                    if (document.querySelector("input[name=paymentMethodId]") == null) {
                        //cria um hidden
                        var paymentMethod = document.createElement('input');
                        paymentMethod.setAttribute('name', "paymentMethodId");
                        paymentMethod.setAttribute('type', "hidden");
                        paymentMethod.setAttribute('value', response[0].id);
                        form.appendChild(paymentMethod);
                    } else {
                        document.querySelector("input[name=paymentMethodId]").value = response[0].id;
                    }

                    var img = "<img src='" + response[0].thumbnail + "'>";
                    $("#form1 #img_bandeira").empty();
                    $("#form1 #img_bandeira").append(img);

                    amount = $("#form1 .total").val();

                    Mercadopago.getInstallments({
                        "bin": getBin(),
                        "amount": amount
                    }, setInstallmentInfo);
                }
            };

            function setInstallmentInfo(status, response) {

                var selectorInstallments = document.querySelector("#form1 #parcelamento"),
                    fragment = document.createDocumentFragment();
                selectorInstallments.options.length = 0;

                if (response.length > 0) {
                    var option = new Option("Escolha...", ''),
                        payerCosts = response[0].payer_costs;
                    fragment.appendChild(option);

                    //for (var i = 0; i < payerCosts.length; i++) {  //Pega todas as opções de pagamento
                    for (var i = 0; i < 1; i++) {  //Pega só a venda a vista
                        option = new Option(payerCosts[i].recommended_message || payerCosts[i].installments, payerCosts[i].installments + '-' + payerCosts[i].total_amount);
                        fragment.appendChild(option);
                    }

                    selectorInstallments.appendChild(fragment);
                    selectorInstallments.removeAttribute('disabled');
                }
            };

            addEvent(document.querySelector('#form1 input[data-checkout="cardNumber"]'), 'keyup', guessingPaymentMethod);
            addEvent(document.querySelector('#form1 input[data-checkout="cardNumber"]'), 'change', guessingPaymentMethod);

        });

    </script>

@stop
