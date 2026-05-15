<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMail;

/**
 * ContactoController - Gestiona el formulario de contacto de la joyería.
 *
 * Permite a los visitantes enviar mensajes al equipo a través de un
 * formulario web que se traduce en un correo electrónico.
 */
class ContactoController extends Controller
{
    /**
     * Muestra la página de contacto.
     *
     * @return \Illuminate\View\View
     */
    public function contacto()
    {
        return view('pages.contacto');
    }

    /**
     * Procesa y envía el mensaje de contacto por correo.
     *
     * Valida los campos requeridos y utiliza ContactoMail para notificar
     * a la dirección configurada en MAIL_TO_ADDRESS.
     *
     * @param \Illuminate\Http\Request $request Datos del formulario de contacto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'asunto' => 'required',
            'mensaje' => 'required',
        ]);

        //Logica de enviar email
        try {
            Mail::to(env('MAIL_TO_ADDRESS'))->send(new ContactoMail($request->all()));

            return back()->with('success', 'Tu mensaje se ha enviado correctamente.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
