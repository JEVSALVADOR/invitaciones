<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index(Event $event): View
    {
        $guests = $event->guests()->with('rsvpResponse')->paginate(30);
        return view('admin.guests.index', compact('event', 'guests'));
    }

    public function create(Event $event): View
    {
        return view('admin.guests.create', compact('event'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name'       => 'required|string|max:200',
            'seats_reserved'   => 'required|integer|min:1|max:20',
            'phone'            => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:200',
            'personal_message' => 'nullable|string|max:500',
        ]);

        $event->guests()->create($validated);

        return redirect()->route('admin.events.guests.index', $event)
            ->with('success', 'Invitado agregado.');
    }

    public function edit(EventGuest $guest): View
    {
        return view('admin.guests.edit', compact('guest'));
    }

    public function update(Request $request, EventGuest $guest): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name'       => 'required|string|max:200',
            'seats_reserved'   => 'required|integer|min:1|max:20',
            'phone'            => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:200',
            'personal_message' => 'nullable|string|max:500',
        ]);

        $guest->update($validated);

        return redirect()->route('admin.events.guests.index', $guest->event_id)
            ->with('success', 'Invitado actualizado.');
    }

    public function destroy(EventGuest $guest): RedirectResponse
    {
        $eventId = $guest->event_id;
        $guest->delete();
        return redirect()->route('admin.events.guests.index', $eventId)
            ->with('success', 'Invitado eliminado.');
    }

    public function export(Event $event)
    {
        $guests = $event->guests()->with('rsvpResponse')->get();
        $csv = "Nombre,Asientos,Teléfono,Email,URL Invitación,RSVP\n";
        $ids  = [];

        foreach ($guests as $g) {
            $url  = url("/i/{$event->uuid}/{$g->guest_slug}");
            $rsvp = $g->rsvpResponse?->attendance_option ?? 'Sin respuesta';
            $csv .= "\"{$g->guest_name}\",{$g->seats_reserved},\"{$g->phone}\",\"{$g->email}\",\"{$url}\",\"{$rsvp}\"\n";
            if (! $g->invitation_sent) $ids[] = $g->id;
        }

        if (! empty($ids)) {
            \App\Models\EventGuest::whereIn('id', $ids)->update([
                'invitation_sent'    => true,
                'invitation_sent_at' => now(),
            ]);
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=invitados-{$event->uuid}.csv",
        ]);
    }
}
