<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventItinerary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItineraryController extends Controller
{
    public function update(Request $request, EventItinerary $itinerary): JsonResponse
    {
        $validated = $request->validate([
            'time_label'    => 'required|string|max:20',
            'event_time'    => 'required|date_format:H:i,H:i:s',
            'activity_name' => 'required|string|max:200',
            'icon_type'     => 'required|string',
            'position'      => 'required|in:left,right',
        ]);

        $itinerary->update($validated);
        return response()->json(['success' => true]);
    }

    public function destroy(EventItinerary $itinerary): JsonResponse
    {
        if ($itinerary->icon_image) {
            Storage::disk('public')->delete($itinerary->icon_image);
        }
        $itinerary->delete();
        return response()->json(['success' => true]);
    }

    public function uploadIcon(Request $request, EventItinerary $itinerary): JsonResponse
    {
        $request->validate([
            'icon_file' => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
        ]);

        if ($itinerary->icon_image) {
            Storage::disk('public')->delete($itinerary->icon_image);
        }

        $path = $request->file('icon_file')->store(
            "events/{$itinerary->event_id}/itinerary", 'public'
        );

        $itinerary->update(['icon_image' => $path]);

        return response()->json(['success' => true, 'url' => Storage::url($path)]);
    }

    public function deleteIcon(EventItinerary $itinerary): JsonResponse
    {
        if ($itinerary->icon_image) {
            Storage::disk('public')->delete($itinerary->icon_image);
            $itinerary->update(['icon_image' => null]);
        }
        return response()->json(['success' => true]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_id'      => 'required|exists:events,id',
            'time_label'    => 'required|string|max:20',
            'event_time'    => 'required|date_format:H:i,H:i:s',
            'activity_name' => 'required|string|max:200',
            'icon_type'     => 'required|string',
            'position'      => 'required|in:left,right',
        ]);

        $item = EventItinerary::create(array_merge($validated, [
            'sort_order' => EventItinerary::where('event_id', $validated['event_id'])->max('sort_order') + 1,
        ]));

        return response()->json(['success' => true, 'id' => $item->id]);
    }
}
