@extends('adminlte::page')

@section('title', 'eCondominio')

@section('content_header')

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Sistema de Controle de Condomínios</h2>
	</div>
	<div class="panel-body">
		<p> Para geração dos boletos é necessário:</p>
		<ul>
			<li>Clicar em Administração/Empresas/Alterar e fornecer os dados da sua conta de recebimento: (CNPJ, CEP, Banco, Agencia, Conta, Carteira e Convênio).  </li>
			<li>Cadastrar os Proprietarios (CPF, Nome e CEP são obrigatórios). </li>
            <li>Cadastrar as Unidades (Terrenos, Apartamentos, Lotes, etc) associando com os proprietários. </li>
            <li> Mensalmente será necessário: </li>
                <ul>
                    <li>Cadastrar a Taxas, informando o AnoMes, Vencimento e Valor do condomínio! </li>
                    <li>Gerar as mensalidades na opção "Rotinas Financeiras->Gerar Mensalidades"</li>
                    <li>Transmitir o arquivo para o banco "Rotinas Financeiras->Gerar Remessa" </li>
                    <li>Imprimir ou enviar os boletos por email "Cadastros->Debitos" (vide manual)
                </ul>
        </ul>
        <p>O <a href='manual'>manual do usuário</a> detalha cada um dos procedimentos acima citados</p>
        <br/>
        <p>Para facilitar a utilização do Sistema eCondominio, a Pegasus Sistemas fornece uma <a href='planilha'>planilha </a> onde você pode preencher os dados dos proprietários/apartamentos e enviar os dados para importação automatica do sistema. Após preenchida a planilha deve ser enviada para systems.pegasus@gmail.com.
        </p>
	</div>
</div>
@stop

@section('content')


@stop
