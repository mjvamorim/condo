<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

use App\Models\Debito;

class SendMailFaleConosco extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 1;
    public $nome;
    public $email;
    public $assunto;
    public $mensagem;

    public function __construct($nome, $email, $assunto, $mensagem)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;

    }

    public function build()
    {
        $emailFrom = $this->email;
        return $this->from($emailFrom)
                ->view('emails.FaleConosco')
                ->subject('Econdominio Fale Conosco -> '.$this->assunto)
                ->with([
                    'mensagem' => $this->mensagem,
                    'nome' => $this->nome,
                    'email' => $this->email,
                ]);
    }
}
