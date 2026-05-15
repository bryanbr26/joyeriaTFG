<?php

namespace App\Http\Controllers;

use App\Mail\OrfebreriaCitaMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * OrfebreriaController - Gestiona la sección de orfebrería y citas.
 *
 * Permite a los visitantes solicitar citas presenciales para encargos,
 * diseños personalizados, reparaciones, tasaciones y otros servicios.
 */
class OrfebreriaController extends Controller
{
    /**
     * Muestra la página de orfebrería.
     *
     * @return \Illuminate\View\View
     */
    public function orfebreria()
    {
        return view('pages.orfebreria');
    }

    /**
     * Procesa y envía la solicitud de cita de orfebrería por correo.
     *
     * Valida los datos, comprueba que la fecha no sea pasada y notifica
     * al equipo mediante OrfebreriaCitaMail.
     *
     * @param \Illuminate\Http\Request $request Datos del formulario de cita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviarCita(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'telefono' => 'nullable|string|max:40',
            'proposito' => 'required|string|in:productos,servicios,otro',
            'motivo' => 'required|string|in:joyeria,encargo,diseno-propio,reparacion,tasacion,otro',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'comentarios' => 'nullable|string|max:2000',
        ]);

        if (Carbon::parse($datos['fecha'] . ' ' . $datos['hora'])->isPast()) {
            return back()
                ->withInput()
                ->withErrors(['fecha' => 'La fecha y hora de la cita no pueden ser anteriores al momento actual.']);
        }

        try {
            Mail::to(env('MAIL_TO_ADDRESS'))->send(new OrfebreriaCitaMail($datos));

            return back()->with('success', 'Tu cita se ha enviado correctamente. Te contactaremos para confirmarla.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo enviar la cita. Inténtalo de nuevo en unos minutos.');
        }
    }
}
