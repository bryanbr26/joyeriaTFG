<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrfebreriaCitaMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $datos;

    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    public function build()
    {
        return $this->subject('Nueva solicitud de cita de orfebrería')
            ->replyTo($this->datos['email'], $this->datos['nombre'])
            ->view('emails.orfebreria-cita');
    }
}
