<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;

class RsvpController extends Controller
{
    public function index(Event $event): View
    {
        $responses = $event->rsvpResponses()
            ->with('guest')
            ->latest('responded_at')
            ->paginate(30);

        $stats = [
            'total'        => $event->rsvpResponses()->count(),
            'solo_yo'      => $event->rsvpResponses()->where('attendance_option', 'solo_yo')->count(),
            'yo_y_pareja'  => $event->rsvpResponses()->where('attendance_option', 'yo_y_pareja')->count(),
            'no_asistire'  => $event->rsvpResponses()->where('attendance_option', 'no_asistire')->count(),
            'total_seats'  => $event->confirmed_seats,
        ];

        return view('admin.rsvp.index', compact('event', 'responses', 'stats'));
    }

    public function export(Event $event)
    {
        $responses = $event->rsvpResponses()->with('guest')->latest('responded_at')->get();

        $labels = [
            'solo_yo'      => '1 persona (solo yo)',
            'yo_y_pareja'  => '2 personas (yo y pareja)',
            'no_asistire'  => 'No asistirá',
        ];

        $csv = "Nombre,Asistencia,Personas,Invitado vinculado,Teléfono,Mensaje,Fecha respuesta\n";
        foreach ($responses as $r) {
            $asistencia  = $labels[$r->attendance_option] ?? $r->attendance_option;
            $vinculado   = $r->guest?->guest_name ?? '—';
            $fecha       = $r->responded_at->format('Y-m-d H:i');
            $mensaje     = str_replace(['"', "\n"], ["'", ' '], $r->message ?? '');
            $csv .= "\"{$r->respondent_name}\",\"{$asistencia}\",{$r->total_attendees},\"{$vinculado}\",\"{$r->phone_contact}\",\"{$mensaje}\",\"{$fecha}\"\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=rsvp-{$event->uuid}.csv",
        ]);
    }
}
