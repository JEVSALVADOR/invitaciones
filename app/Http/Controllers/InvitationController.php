<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventGuest;
use App\Models\RsvpResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InvitationController extends Controller
{
    public function show(string $uuid): View|RedirectResponse
    {
        $event = Event::with([
            'theme', 'media', 'locations', 'itinerary',
            'mainPhoto', 'secondPhoto', 'thirdPhoto',
            'floralTopLeft', 'floralBottomRight', 'floralEnvelope',
            'floralDivider', 'floralCalTl', 'floralCalBr',
            'sealClosed', 'sealOpen',
            'tornTop', 'tornBottom',
        ])
            ->where('uuid', $uuid)
            ->published()
            ->firstOrFail();

        return view('invitation.show', [
            'event'     => $event,
            'theme'     => $event->theme,
            'guest'     => null,
            'guestName' => null,
        ]);
    }

    public function showPersonalized(string $uuid, string $guestSlug): View|RedirectResponse
    {
        $event = Event::with([
            'theme', 'media', 'locations', 'itinerary',
            'mainPhoto', 'secondPhoto', 'thirdPhoto',
            'floralTopLeft', 'floralBottomRight', 'floralEnvelope',
            'floralDivider', 'floralCalTl', 'floralCalBr',
            'sealClosed', 'sealOpen',
            'tornTop', 'tornBottom',
        ])
            ->where('uuid', $uuid)
            ->published()
            ->firstOrFail();

        $guest = EventGuest::where('event_id', $event->id)
            ->where('guest_slug', $guestSlug)
            ->first();

        return view('invitation.show', [
            'event'     => $event,
            'theme'     => $event->theme,
            'guest'     => $guest,
            'guestName' => $guest?->guest_name,
        ]);
    }

    public function submitRsvp(Request $request, string $uuid): JsonResponse
    {
        $event = Event::where('uuid', $uuid)->published()->firstOrFail();

        $validated = $request->validate([
            'respondent_name'   => 'required|string|max:200',
            'attendance_option' => 'required|in:solo_yo,yo_y_pareja,no_asistire',
            'message'           => 'nullable|string|max:500',
            'phone_contact'     => 'nullable|string|max:20',
        ]);

        $totalAttendees = match ($validated['attendance_option']) {
            'solo_yo'     => 1,
            'yo_y_pareja' => 2,
            default       => 0,
        };

        $guestId = $request->input('guest_id');
        if ($guestId) {
            $exists = \App\Models\EventGuest::where('id', $guestId)
                ->where('event_id', $event->id)
                ->exists();
            if (! $exists) $guestId = null;
        }

        $rsvp = RsvpResponse::create([
            'event_id'          => $event->id,
            'guest_id'          => $guestId ?: null,
            'respondent_name'   => $validated['respondent_name'],
            'attendance_option' => $validated['attendance_option'],
            'total_attendees'   => $totalAttendees,
            'message'           => $validated['message'] ?? null,
            'phone_contact'     => $validated['phone_contact'] ?? null,
            'ip_address'        => $request->ip(),
        ]);

        if ($totalAttendees > 0) {
            $event->increment('confirmed_seats', $totalAttendees);
        }

        return response()->json([
            'success' => true,
            'name'    => $validated['respondent_name'],
        ]);
    }
}
