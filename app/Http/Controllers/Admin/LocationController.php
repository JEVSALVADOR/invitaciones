<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function update(Request $request, EventLocation $location): JsonResponse
    {
        $validated = $request->validate([
            'location_type'    => 'required|string|max:100',
            'venue_name'       => 'nullable|string|max:200',
            'address'          => 'required|string',
            'city'             => 'nullable|string|max:100',
            'google_maps_url'  => 'nullable|url',
            'event_time'       => 'nullable|date_format:H:i,H:i:s',
        ]);

        $location->update($validated);
        return response()->json(['success' => true]);
    }

    public function destroy(EventLocation $location): JsonResponse
    {
        $location->delete();
        return response()->json(['success' => true]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_id'        => 'required|exists:events,id',
            'location_type'   => 'nullable|string|max:100',
            'venue_name'      => 'nullable|string|max:200',
            'address'         => 'nullable|string',
            'google_maps_url' => 'nullable|url',
            'event_time'      => 'nullable|date_format:H:i,H:i:s',
        ]);

        $loc = EventLocation::create($validated);
        return response()->json(['success' => true, 'id' => $loc->id]);
    }
}
