<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MensajeIngresante extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Bienvenido(a) a la Universidad Nacional de Música';

    public $enlace;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enlace)
    {
        $this->enlace = $enlace;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ingresante');
    }
}
