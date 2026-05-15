<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * ContactoMail - Correo electrónico de notificación de contacto.
 *
 * Envía al equipo los datos recibidos a través del formulario de contacto
 * de la página web.
 */
class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<string, mixed> Datos del formulario de contacto */
    public array $datos;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param array<string, mixed> $datos Datos del formulario
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
        return $this->subject('Nuevo mensaje de contacto: ' . ucfirst($this->datos['asunto']))
                    ->replyTo($this->datos['email'], $this->datos['nombre'])
                    ->view('emails.contacto');
    }
}
