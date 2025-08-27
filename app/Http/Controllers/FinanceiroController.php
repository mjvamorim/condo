<?php

namespace App\Http\Controllers;

use App\Mail\SendMailBoleto;
use App\Models\Debito;
use App\Models\Email;
use App\Models\Proprietario;
use App\Models\Taxa;
use App\Models\Unidade;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FinanceiroController extends Controller
{
    private $baixas_path;
    private $boletos_path;
    private $boleto_msg = 'Após o vencimento aplicar multa de 2% + 1% de juros ao mês ';

    public function __construct()
    {
        $this->baixas_path = storage_path('baixas');
        if (!is_dir($this->baixas_path)) {
            mkdir($this->baixas_path, 0777);
        }
        $this->boletos_path = storage_path('boletos');
        if (!is_dir($this->boletos_path)) {
            mkdir($this->boletos_path, 0777);
        }
    }

    // -------------------------frmGerarMensalidades-------------------------------//
    public function frmGerarMensalidades()
    {
        $taxas = Taxa::orderBy('anomes', 'desc')->get();

        return view('financeiro.FrmGerarMensalidades', compact('taxas'));
    }


    // -------------------------gerarMensalidades-------------------------------//
    public function gerarMensalidades(Request $request)
    {
        $taxa_id = $request->input('taxa_id');
        $taxa = Taxa::find($taxa_id);
        $unidades = Unidade::all()->sortBy('descricao');
        foreach ($unidades as $unidade) {
            // Verifica se já existe débitos criados para aquela unidade naquele mes
            $debito = Debito::where('taxa_id', '=', $taxa->id)
                ->where('unidade_id', '=', $unidade->id)
                ->first()
            ;
            // Se não existe, cria a mensalidade
            if (!$debito) {
                $debito = new Debito();
            }
            if (null == $debito->dtpagto) {
                $debito->unidade_id = $unidade->id;
                $debito->tipo = 'Mensalidade';
                $debito->taxa_id = $taxa->id;
                $debito->acordo_id = null;
                $debito->dtvencto = $taxa->dtvencto;
                $debito->valor = $taxa->valor;
                $debito->obs = '';
                if ($unidade->adicional) {
                    if ('Percentual' == $unidade->tipo_adicional) {
                        $debito->valor = $taxa->valor * (1 + $unidade->adicional / 100);
                    } else {
                        $debito->valor = $taxa->valor + $unidade->adicional;
                    }
                    $debito->obs = 'Adicional de R$ '.money_format('%i', $debito->valor - $taxa->valor);
                }

                $debito->dtpagto = null;
                $debito->valorpago = null;
                $debito->acordo_quitacao_id = null;
                $debito->save();
                $debito->boleto = $debito->id;
                $debito->save();
            }
        }

        return redirect()->route('home')->withSuccess(['Boletos Gerados!']);
    }

   // -------------------------FrmImprimirBoletos-------------------------------//
   public function frmImprimirBoletos()
   {
       $taxas = Taxa::orderBy('anomes', 'desc')->get();
       $proprietarios = Proprietario::orderBy('nome')->get();
       $unidades = Unidade::orderBy('descricao')->get();

       return view('financeiro.FrmImprimirBoletos', compact('taxas', 'proprietarios', 'unidades'));
   }

    // -----------------------------Boleto Impresso Href-------------------------------//
    public function imprimirBoletos(Request $request)
    {
        if (!$this->empresaValida()) {
            return redirect('/crud/empresa')->withError(['O banco, agencia ou numero da conta precisam ser configurados no cadastro da empresa']);
        }

        $debitos = Debito::whereNull('dtpagto')
            ->where(DebitoController::clausulaWhere($request))
            ->get()
        ;

        if ($request->input('proprietario_id') && '00' != $request->input('proprietario_id')) {
            $filtered = [];
            foreach ($debitos as $debito) {
                if ($debito->unidade->proprietario_id == $request->input('proprietario_id')) {
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }
        if ($request->input('envio_boleto') && 'Todos' != $request->input('envio_boleto')) {
            $filtered = [];
            foreach ($debitos as $debito) {
                if ($debito->unidade->envio_boleto == $request->input('envio_boleto') or 'Ambos' == $debito->unidade->envio_boleto) {
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }
        if ($request->input('descricao') && $request->input('descricao')!='') {
            $filtered = [];
            foreach($debitos as $debito){
                if(stripos($debito->unidade->descricao, $request->input('descricao')) !== false){
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }

        if (0 == $debitos->count()) {
            return redirect()->route('home')->withError(['Não existem boletos a serem impressos!']);
        }

        $pdf = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();
        foreach ($debitos as $debito) {
            if (empty($debito->boleto)) {
                $debito->boleto = $debito->id;
                $debito->save();
            }
            $boleto = $this->montaBoleto($debito);

            $pdf->addBoleto($boleto);
        }
        // Escolha do nome do arquivo
        $file = $this->nomeArquivo($request);
        $pdf->gerarBoleto($pdf::OUTPUT_SAVE, $file);

        return response()->download($file)->deleteFileAfterSend();
    }

    // ---------------------------Boleto por email (Ajax) -------------------------------//
    public function emailBoletos(Request $request)
    {
        if (!$this->empresaValida()) {
            return response()->json(['error' => 'O banco, agencia ou numero da conta precisam ser configurados no cadastro da empresa'], 404);
        }

        $debitos = Debito::whereNull('dtpagto')
            ->where(DebitoController::clausulaWhere($request))
            ->get()
        ;

        if ($request->input('proprietario_id') && '00' != $request->input('proprietario_id')) {
            $filtered = [];
            foreach ($debitos as $debito) {
                if ($debito->unidade->proprietario_id == $request->input('proprietario_id')) {
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }
        if ($request->input('envio_boleto') && 'Todos' != $request->input('envio_boleto')) {
            $filtered = [];
            foreach ($debitos as $debito) {
                if ($debito->unidade->envio_boleto == $request->input('envio_boleto') or 'Ambos' == $debito->unidade->envio_boleto) {
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }
        if ($request->input('descricao') && $request->input('descricao')!='') {
            $filtered = [];
            foreach($debitos as $debito){
                if(stripos($debito->unidade->descricao, $request->input('descricao')) !== false){
                    $filtered[] = $debito;
                }
            }
            $debitos = collect($filtered);
        }

        $errors = [];
        $success = true;
        if (0 == $debitos->count()) {
            $errors[] = ['Não existem boletos a serem enviados!'];

            return response()->json(['success' => 'false', 'errors' => $errors], 400);
        }

        foreach ($debitos as $debito) {
            $emailTo = $debito->unidade->proprietario->email;
            if (filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
                $pdf = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();
                if (empty($debito->boleto)) { // Coloca o id como numero do boleto se for vazio
                    $debito->boleto = $debito->id;
                    $debito->save();
                }

                $boleto = $this->montaBoleto($debito);
                $pdf->addBoleto($boleto);
                $file = $this->nomeArquivo($request);
                $file = substr($file, 0, strlen($file) - 4).'_'.$debito->id.'.pdf';
                $pdf->gerarBoleto($pdf::OUTPUT_SAVE, $file);
                Mail::to($emailTo)->send(
                    new SendMailBoleto(
                        $debito->unidade->proprietario->nome,
                        $debito->tipo,
                        $debito->taxa_id ? $debito->taxa->anomes : 0,
                        $debito->acordo_id,
                        $debito->id,
                        $debito->valor,
                        $debito->dtvencto,
                        Auth::user()->empresa->nome,
                        Auth::user()->empresa->email,
                        'Boleto Condominial',
                        $file
                    )
                );

                // Grava o log de email enviado
                $email = new Email();
                $email->de = Auth::user()->empresa->email;
                $email->para = $emailTo;
                $email->anexo = $file;
                $email->assunto = 'Boleto Condominial';

                switch ($debito->tipo) {
                    case 'Mensalidade':
                        $email->mensagem = 'Taxa Condominial '.$debito->taxa->anomes;

                        break;

                    case 'Acordo':
                        $email->mensagem = 'Acordo Nº '.$debito->acordo_id;

                        break;

                    case 'Multa':
                        $email->mensagem = 'Multa Nº '.$debito->id;

                        break;

                    default:
                        $email->mensagem = 'Boleto Avulso Nº '.$debito->id;

                        break;
                }

                $email->save();

            // dispatch(new SendMailBoletoJob($debito,'Boleto Condominial',$file));
            } else {
                if ($request->input('debito_id') && '0' != $request->input('debito_id')) {
                    $success = false;
                    $errors[] = ['Email do proprietário da unidade '.$debito->unidade->descricao.' é inválido'];
                } else {
                    if ('' != $debito->unidade->proprietario->email) {
                        $success = false;
                        $errors[] = ['Email do proprietário da unidade '.$debito->unidade->descricao.' é inválido'];
                    }
                }
            }
        }
        if (!$success) {
            return response()->json(['success' => 'false', 'errors' => $errors], 400);
        }

        return response()->json(['success' => true], 200);
    }

    // ------------------------------------FrmBaixasBancarias--------------------------------//
    public function frmBaixasBancaria()
    {
        return view('financeiro.FrmBaixasBancaria');
    }

    // ------------------------------------BaixasBancarias-----------------------------------//
    public function baixasBancaria(Request $request)
    {
        // Pegar arquivo
        $files = $request->file('file');

        if (!is_array($files)) {
            $files = [$files];
        }

        $file = $files[0];
        // $name = sha1(date('YmdHis') . str_random(30)).'ret';
        $name = $file->getClientOriginalName();
        $file->move($this->baixas_path, $name);
        $file_full_name = $this->baixas_path.DIRECTORY_SEPARATOR.$name;

        $retorno = \Eduardokum\LaravelBoleto\Cnab\Retorno\Factory::make($file_full_name);
        $retorno->processar();
        $saida = PHP_EOL.'***************** Data: '.date('d-m-Y').' Arquivo: '.$name.'  ***************** ';
        foreach ($retorno->getDetalhes() as $detalhe) {
            // Ocorrencias
            // 02-Entrada Confirmada
            // 03-Entrada Rejeitada - Ver motivo
            // 06-Baixa
            $baixou = 'Não';
            $unidade = '';
            $dtvencto = '';
            if ('06' == $detalhe->ocorrencia) { // Baixa
                $debito = Debito::where('boleto', $detalhe->numeroDocumento)->first();
                if ($debito) {
                    $debito->dtpagto = Carbon::createFromFormat('d/m/Y', $detalhe->dataCredito)->format('Y-m-d');
                    $debito->valorpago = $detalhe->valorRecebido + $detalhe->valorTarifa;
                    $debito->save();
                    $baixou = 'Sim';
                    $unidade = $debito->unidade->descricao;
                    $dtvencto = $debito->dtvencto;
                }
            }
            $saida .= PHP_EOL.'Boleto: '.sprintf('%08d', $detalhe->numeroDocumento)
               .'  '.$detalhe->ocorrencia
                .'-'.substr(str_pad($detalhe->ocorrenciaDescricao, 45, ' '), 0, 45);
            if ('06' == $detalhe->ocorrencia) {
                $saida .= ' Valor: '.money_format('%(#10n', $detalhe->valorRecebido + $detalhe->valorTarifa)
               .' Dt.Pagto: '.$detalhe->dataCredito
               .' Baixou: '.$baixou
               .' Unidade: '.$unidade
               .' - '.$dtvencto;
            }

            $saida .= '  '.$detalhe->error;
        }
        $saida .= PHP_EOL.PHP_EOL;
        $arq = 'Log-Retorno-'.auth()->user()->empresa->id.'.txt';
        Storage::append($arq, $saida);

        return response()->json($saida);

        return $saida;
    }

    public function baixasBancariaApi(Request $request)
    {
        // Pegar arquivo
        $files = $request->file('files');

        if (!is_array($files)) {
            $files = [$files];
        }
        // $file = $files[0];
        $saida = ' ';
        foreach ($files as $file) {
            // $name = sha1(date('YmdHis') . str_random(30)).'ret';
            $name = $file->getClientOriginalName();
            $file->move($this->baixas_path, $name);
            $file_full_name = $this->baixas_path.DIRECTORY_SEPARATOR.$name;

            $retorno = \Eduardokum\LaravelBoleto\Cnab\Retorno\Factory::make($file_full_name);
            $retorno->processar();
            $saida .= PHP_EOL.'***************** Data: '.date('d-m-Y').' Arquivo: '.$name.'  ***************** ';
            foreach ($retorno->getDetalhes() as $detalhe) {
                // Ocorrencias
                // 02-Entrada Confirmada
                // 03-Entrada Rejeitada - Ver motivo
                // 06-Baixa
                $baixou = 'Não';
                $unidade = '';
                $dtvencto = '';
                if ('06' == $detalhe->ocorrencia) { // Baixa
                    $debito = Debito::where('boleto', $detalhe->numeroDocumento)->first();
                    if ($debito) {
                        $debito->dtpagto = Carbon::createFromFormat('d/m/Y', $detalhe->dataCredito)->format('Y-m-d');
                        $debito->valorpago = $detalhe->valorRecebido + $detalhe->valorTarifa;
                        $debito->save();
                        $baixou = 'Sim';
                        $unidade = $debito->unidade->descricao;
                        $dtvencto = $debito->dtvencto;
                    }
                }
                $saida .= PHP_EOL.'Boleto: '.sprintf('%08d', $detalhe->numeroDocumento)
                   .'  '.$detalhe->ocorrencia
                    .'-'.substr(str_pad($detalhe->ocorrenciaDescricao, 45, ' '), 0, 45);
                if ('06' == $detalhe->ocorrencia) {
                    $saida .= ' Valor: '.money_format('%(#10n', $detalhe->valorRecebido + $detalhe->valorTarifa)
                   .' Dt.Pagto: '.$detalhe->dataCredito
                   .' Baixou: '.$baixou
                   .' Unidade: '.$unidade
                   .' - '.$dtvencto;
                }

                $saida .= '  '.$detalhe->error;
            }
        }
        $saida .= PHP_EOL.PHP_EOL;
        $arq = 'Log-Retorno-'.auth()->user()->empresa->id.'.txt';
        Storage::append($arq, $saida);

        return response()->json($saida);

        return $saida;
    }

    // ------------------------------------FrmGerarRemessa-----------------------------------//
    public function frmGerarRemessa()
    {
        return view('financeiro.FrmGerarRemessa');
    }

    // ------------------------------------GerarRemessa-----------------------------------//
    public function gerarRemessa(Request $request)
    {
        if (!$this->empresaValida()) {
            return response()->json(['error' => 'O banco, agencia ou numero da conta precisam ser configurados no cadastro da empresa'], 404);
            // return redirect('/crud/empresa')->withError(['O banco, agencia ou numero da conta precisam ser configurados no cadastro da empresa']);
        }

        $remessa = $this->montaRemessa();

        $clausulaWhere = [];
        $clausulaWhere[] = ['remessa', '=', 'N'];
        $debitos = Debito::whereNull('dtpagto')
            ->where($clausulaWhere)
            ->get()
        ;
        if (0 == $debitos->count()) {
            // return redirect()->route('home')->withError(['Não existem remessas a serem enviadas!']);
            return response()->json(['error' => 'O banco, agencia ou numero da conta precisam ser configurados no cadastro da empresa'], 404);
        }

        foreach ($debitos as $debito) {
            if (empty($debito->boleto)) {
                $debito->boleto = $debito->id;
                $debito->save();
            }
            $boleto = $this->montaBoleto($debito);
            $remessa->addBoleto($boleto);
        } // foreach
        $name = date('Ymd').'.txt';
        $file = $this->baixas_path.DIRECTORY_SEPARATOR.$name;
        $remessa->save($file);
        Debito::where('remessa', '=', 'N')->update(['remessa' => 'S']);

        return response()->download($file)->deleteFileAfterSend();
    }

    // --------------------------Listagem Debitos ----------------------------//
    public function listagemDebitos(Request $request)
    {
        // Chama a função que monta a cláusula where
        $clausulaWhere = $this->clausulaWhereQuery($request);
        // Monta a Clausula de Ordenação
        $ordem = $request->input('ordem');
        $clausulaOrderBy = 'proprietarios.nome, unidades.descricao, debitos.dtvencto asc';
        if (!empty($ordem)) {
            switch ($ordem) {
                case 'Unidade':
                    $clausulaOrderBy = 'unidades.descricao, debitos.dtvencto asc';

                    break;

                case 'Pagamento':
                    $clausulaOrderBy = 'debitos.dtpagto asc';

                    break;

                case 'Vencimento':
                    $clausulaOrderBy = 'debitos.dtvencto, proprietarios.nome, unidades.descricao  asc';

                    break;
            }
        }
        $debitos = DB::connection('tenant')->table('debitos')
            ->join('unidades', 'debitos.unidade_id', '=', 'unidades.id')
            ->join('proprietarios', 'unidades.proprietario_id', '=', 'proprietarios.id')
            ->leftJoin('taxas', 'debitos.taxa_id', '=', 'taxas.id')
            ->where($clausulaWhere)
            ->orderByRaw($clausulaOrderBy)
            ->select('debitos.*', 'proprietarios.nome', 'proprietarios.conjuge_nome', 'taxas.anomes', 'unidades.descricao')
            ->get()
        ;

        return view('listagens.ListagemDebitos', compact('debitos', 'ordem'));
    }

    // -------------------------clausulaWhereQuery-------------------------------//
    public function clausulaWhereQuery(Request $request)
    {
        $clausulaWhere = [['debitos.id', '>', '0']];
        if ($request->input('proprietario_id') && '00' != $request->input('proprietario_id')) {
            $clausulaWhere[] = ['unidades.proprietario_id', '=', $request->input('proprietario_id')];
        }
        if ($request->input('taxa_id') && '00' != $request->input('taxa_id')) {
            $clausulaWhere[] = ['debitos.taxa_id', '=', $request->input('taxa_id')];
        }
        if ($request->input('unidade_id') && '00' != $request->input('unidade_id')) {
            $clausulaWhere[] = ['debitos.unidade_id', $request->input('unidade_id')];
        }
        if ($request->input('debito_id') && '0' != $request->input('debito_id')) {
            $clausulaWhere[] = ['debitos.id', $request->input('debito_id')];
        }

        if ($request->input('tipo_id') && 'Todos' != $request->input('tipo_id')) {
            $clausulaWhere[] = ['debitos.tipo', $request->input('tipo_id')];
        }
        if ($request->input('descricao') && $request->input('descricao')!='') {
            $clausulaWhere[] = ['unidades.descricao', 'like', '%'.$request->input('descricao').'%'];
        }

        switch ($request->input('condicao')) {
            case 'Pagos':
                if ($request->input('dtini') && '' != $request->input('dtini')) {
                    $clausulaWhere[] = ['debitos.dtpagto', '>=', $request->input('dtini')];
                }
                if ($request->input('dtfim') && '' != $request->input('dtfim')) {
                    $clausulaWhere[] = ['debitos.dtpagto', '<=', $request->input('dtfim')];
                }
                $clausulaWhere[] = ['debitos.dtpagto', '<>', null];

                break;

            case 'Abertos':
                if ($request->input('dtini') && '' != $request->input('dtini')) {
                    $clausulaWhere[] = ['debitos.dtvencto', '>=', $request->input('dtini')];
                }
                if ($request->input('dtfim') && '' != $request->input('dtfim')) {
                    $clausulaWhere[] = ['debitos.dtvencto', '<=', $request->input('dtfim')];
                }
                $clausulaWhere[] = ['debitos.dtpagto', null];

                break;

            default:
                if ($request->input('dtini') && '' != $request->input('dtini')) {
                    $clausulaWhere[] = ['debitos.dtvencto', '>=', $request->input('dtini')];
                }
                if ($request->input('dtfim') && '' != $request->input('dtfim')) {
                    $clausulaWhere[] = ['debitos.dtvencto', '<=', $request->input('dtfim')];
                }
        }

        return $clausulaWhere;
    }

   // -------------------------empresaValida-------------------------------//
    private function empresaValida()
    {
        if (0 == Auth::user()->empresa->carteira
            or 0 == Auth::user()->empresa->agencia
            or 0 == Auth::user()->empresa->conta
            or '' == Auth::user()->empresa->nome
            or '' == Auth::user()->empresa->cep
            or '' == Auth::user()->empresa->cpf) {
            return false;
        }

        return true;
    }

    // -------------------------NomeArquivo-------------------------------//
    private function nomeArquivo(Request $request)
    {
        $file = $this->boletos_path.DIRECTORY_SEPARATOR.'Boletos.pdf';
        if ($request->input('taxa_id') && '00' != $request->input('taxa_id')) {
            if ($taxa = Taxa::find($request->input('taxa_id'))) {
                $file = $this->boletos_path.DIRECTORY_SEPARATOR.'Boletos-'.$taxa->anomes.'.pdf';
            }
        }
        if ($request->input('unidade_id') && '00' != $request->input('unidade_id')) {
            if ($unidade = Unidade::find($request->input('unidade_id'))) {
                $file = $this->boletos_path.DIRECTORY_SEPARATOR.'Boletos-'.$unidade->descricao.'.pdf';
            }
        }
        if ($request->input('debito_id') && '0' != $request->input('debito_id')) {
            if ($debito = Debito::find($request->input('debito_id'))) {
                if (empty($debito->taxa_id)) {
                    $file = $this->boletos_path.DIRECTORY_SEPARATOR.'Boletos-'.$debito->unidade->descricao.'-'.$debito->id.'.pdf';
                } else {
                    $file = $this->boletos_path.DIRECTORY_SEPARATOR.'Boletos-'.$debito->unidade->descricao.'-'.$debito->taxa->anomes.'.pdf';
                }
            }
        }

        return $file;
    }

    // -------------------------Beneficiario-------------------------------//
    private function beneficiario()
    {
        return new \Eduardokum\LaravelBoleto\Pessoa(
            [
                'nome' => Auth::user()->empresa->nome,
                'endereco' => Auth::user()->empresa->rua.','.Auth::user()->empresa->numero,
                'cep' => Auth::user()->empresa->cep,
                'uf' => Auth::user()->empresa->uf,
                'cidade' => Auth::user()->empresa->cidade,
                'documento' => Auth::user()->empresa->cpf,
            ]
        );
    }

    // -----------------------------MontaBoleto-------------------------------//
    private function montaBoleto($debito)
    {
        if ($debito->unidade->proprietario->conjuge_nome) {
            $nome = $debito->unidade->proprietario->nome.' & '.$debito->unidade->proprietario->conjuge_nome.'('.$debito->unidade->proprietario->conjuge_cpf.') - '.$debito->unidade->descricao;
        } else {
            $nome = $debito->unidade->proprietario->nome.' - '.$debito->unidade->descricao;
        }

        $pagador = new \Eduardokum\LaravelBoleto\Pessoa(
            [
                'nome' => $nome,
                'endereco' => $debito->unidade->proprietario->rua.','.$debito->unidade->proprietario->numero,
                'bairro' => $debito->unidade->proprietario->bairro,
                'cep' => $debito->unidade->proprietario->cep,
                'uf' => $debito->unidade->proprietario->uf,
                'cidade' => $debito->unidade->proprietario->cidade,
                'documento' => $debito->unidade->proprietario->cpf,
            ]
        );
        $banco = str_pad(Auth::user()->empresa->banco, 3, '0', STR_PAD_LEFT); // Carrega o banco do usuario com 3 posicoes e zero a esquerda
        $class = config('boleto.'.$banco);

        // Acha maior data
        $hoje = Carbon::now();
        $dtvencto = Carbon::createFromFormat('Y-m-d', $debito->dtvencto);
        $data = ($dtvencto > $hoje) ? $dtvencto : $hoje;

        $msg1 = $this->msgDebitosAnteriores($debito->temDebitosAnteriores);
        $msg2 = $this->msgTemAcordosVencer($debito->temAcordosVencer);
        $msg3 = $debito->obs;

        return new $class(
            [
                'logo' => public_path().'/img/pegasus.jpg',
                'dataVencimento' => $data,
                'valor' => $debito->valorAtual,
                'multa' => 2,
                'juros' => 1,
                'numero' => str_pad($debito->boleto, 8, '0', STR_PAD_LEFT), // importante
                'numeroDocumento' => str_pad($debito->boleto, 8, '0', STR_PAD_LEFT),
                'pagador' => $pagador,
                'beneficiario' => $this->beneficiario(),
                'carteira' => Auth::user()->empresa->carteira,
                'agencia' => Auth::user()->empresa->agencia,
                'conta' => Auth::user()->empresa->conta,
                'codigoCliente' => Auth::user()->empresa->convenio,
                'convenio' => Auth::user()->empresa->convenio,
                'descricaoDemonstrativo' => [$this->boleto_msg, 'Unidade: '.$debito->unidade->descricao.' - '.$debito->dtvencto, $msg1, $msg2, $msg3],
                'instrucoes' => [$this->boleto_msg, 'Unidade: '.$debito->unidade->descricao.' - '.$debito->dtvencto, $msg1, $msg2, $msg3],
                'aceite' => 'N',
                'especieDoc' => 'DM',
            ]
        );
    }

    private function msgTemAcordosVencer($value)
    {
        $msg = '';
        if ($value) {
            $msg = '***A Unidade possui  acordos a vencer!***';
        }

        return $msg;
    }

    private function msgDebitosAnteriores($value)
    {
        $msg = 'A unidade não possui débitos em atraso!';
        if ($value) {
            $msg = '***A Unidade possui debitos em atraso!***';
        }

        return $msg;
    }

    // -----------------------------MontaRemessa-------------------------------//
    private function montaRemessa()
    {
        $banco = str_pad(Auth::user()->empresa->banco, 3, '0', STR_PAD_LEFT); // Carrega o banco do usuario com 3 posicoes e zero a esquerda
        $class = config('remessa.'.$banco);

        return new $class(
            [
                'agencia' => Auth::user()->empresa->agencia,
                'conta' => Auth::user()->empresa->conta,
                'contaDv' => Auth::user()->empresa->digito,
                'carteira' => Auth::user()->empresa->carteira,
                'codigoCliente' => Auth::user()->empresa->convenio,
                'beneficiario' => $this->beneficiario(),
            ]
        );
    }
}
