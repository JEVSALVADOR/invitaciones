<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RsvpResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_events'    => Event::count(),
            'published_events' => Event::published()->count(),
            'total_rsvp'      => RsvpResponse::count(),
            'attending_rsvp'  => RsvpResponse::whereIn('attendance_option', ['solo_yo', 'yo_y_pareja'])->count(),
        ];

        $recentEvents = Event::with('theme')
            ->latest()
            ->take(5)
            ->get();

        $recentRsvps = RsvpResponse::with('event')
            ->latest('responded_at')
            ->take(8)
            ->get();

        $upcomingEvents = Event::published()
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentEvents', 'recentRsvps', 'upcomingEvents'
        ));
    }
}
