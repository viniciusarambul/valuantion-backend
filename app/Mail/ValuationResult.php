<?php

namespace App\Mail;

use App\Models\Valuation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValuationResult extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The valuation instance.
     *
     * @var \App\Models\Valuation
     */
    public $valuation;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Valuation  $valuation
     * @return void
     */
    public function __construct(Valuation $valuation)
    {
        $this->valuation = $valuation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->view('emails.valuation')
                    ->with([
                        'nomePessoa' => $this->valuation->nome_pessoa,
                        'nomeEmpresa' => $this->valuation->nome_empresa,
                        'resultado' => $this->valuation->resultado,
                        'email' => $this->valuation->email,
                    ]);
    }
}