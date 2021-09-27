<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MensajeCredenciales extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Pago realizado con éxito';

    public $enlace, $usuario, $contrasena;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enlace, $usuario, $contrasena)
    {
        $this->enlace = $enlace;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.credenciales');
    }
}
