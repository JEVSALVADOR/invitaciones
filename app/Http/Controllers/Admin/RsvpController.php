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
}
