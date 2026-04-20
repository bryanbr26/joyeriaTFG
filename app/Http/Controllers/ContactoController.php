<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMail;

class ContactoController extends Controller
{
    public function contacto()
    {
        return view('pages.contacto');
    }

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
