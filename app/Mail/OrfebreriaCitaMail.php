<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * OrfebreriaCitaMail - Correo electrónico de solicitud de cita de orfebrería.
 *
 * Envía al equipo los datos de una cita solicitada desde la sección
 * de orfebrería de la página web.
 */
class OrfebreriaCitaMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<string, mixed> Datos del formulario de cita */
    public array $datos;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param array<string, mixed> $datos Datos del formulario de cita
     */
    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    /**
     * Construye el mensaje de correo.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nueva solicitud de cita de orfebrería')
            ->replyTo($this->datos['email'], $this->datos['nombre'])
            ->view('emails.orfebreria-cita');
    }
}
