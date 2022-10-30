<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendMailBoleto;
use Mail;

class SendMailBoletoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $debito;
    public $anexo;
    public $assunto;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($debito, $assunto, $anexo)
    {
        $this->debito = $debito;
        $this->assunto = $assunto;
        $this->anexo = $anexo;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$emailTo = $this->debito->unidade->proprietario->email;
        $emailTo='systems.pegasus@gmail.com';
        $email = new SendMailBoleto($this->debito,$this->assunto,$this->anexo);
        Mail::to($emailTo)->send($email);
    }
}
