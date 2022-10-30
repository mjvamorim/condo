<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

use App\Models\Debito;

class SendMailBoleto extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 1;
    public $nome;
    public $tipo;
    public $anomes;
    public $acordo_id;
    public $id;
    public $valor;
    public $dtvencto;
    public $rnome;
    public $remail;
    public $anexo;
    public $assunto;

    public function __construct($nome, $tipo, $anomes, $acordo_id, $id, $valor, $dtvencto, $rnome, $remail, $assunto, $anexo)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->anomes = $anomes;
        $this->acordo_id = $acordo_id;
        $this->id = $id;
        $this->valor = $valor;
        $this->dtvencto = $dtvencto;
        $this->rnome = $rnome;
        $this->remail = $remail;
        $this->assunto = $assunto;
        $this->anexo = $anexo;

    }

    public function build()
    {
        $emailFrom = $this->remail;

        //$emailFrom = 'systems.pegasus@gmail.com';
        if(!filter_var($emailFrom, FILTER_VALIDATE_EMAIL)) {
            $emailFrom = 'econdominio.net@gmail.com';
        }
        return $this->from($emailFrom)
                ->view('emails.Boleto')
                ->subject($this->assunto)
                ->attach($this->anexo)
                ->with([
                    'nome'      => $this->nome,
                    'tipo'      => $this->tipo,
                    'anomes'    => $this->anomes,
                    'acordo_id' => $this->acordo_id,
                    'id'        => $this->id,
                    'valor'     => $this->valor,
                    'dtvencto'  => $this->dtvencto,
                    'rnome'     => $this->rnome,
                    'remail'    => $this->remail,
                ]);
    }
}
