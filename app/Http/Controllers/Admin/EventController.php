<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventMedia;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with('theme')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        $themes = Theme::active()->get();
        return view('admin.events.create', compact('themes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEvent($request);
        $validated['recommendations'] = $this->parseRecommendations($request);

        $event = Event::create($validated);

        return redirect()->route('admin.events.edit', $event)
            ->with('success', 'Evento creado correctamente.');
    }

    public function show(Event $event): RedirectResponse
    {
        return redirect()->route('admin.events.edit', $event);
    }

    public function edit(Event $event): View
    {
        $event->load(['theme', 'media', 'locations', 'itinerary', 'floralTopLeft', 'floralBottomRight', 'floralEnvelope', 'floralDivider', 'floralCalTl', 'floralCalBr', 'sealClosed', 'sealOpen', 'tornTop', 'tornBottom', 'thirdPhoto', 'thirdPhoto2', 'thirdPhoto3', 'thirdPhoto4']);
        $themes = Theme::active()->get();
        return view('admin.events.edit', compact('event', 'themes'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $this->validateEvent($request, $event->id);
        $validated['recommendations'] = $this->parseRecommendations($request);

        foreach (['show_music_player', 'show_dress_code', 'show_gift_suggestion', 'show_recommendations', 'show_rsvp', 'show_countdown', 'show_itinerary'] as $field) {
            $validated[$field] = $request->boolean($field);
        }

        foreach (['color_primary','color_secondary','color_accent','color_bg','color_text','color_envelope','color_seal'] as $col) {
            if (isset($validated[$col]) && trim($validated[$col]) === '') {
                $validated[$col] = null;
            }
        }

        $event->update($validated);

        return redirect()->route('admin.events.edit', $event)
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        // Delete media files
        foreach ($event->media as $media) {
            Storage::disk('public')->delete($media->file_path);
        }
        if ($event->song_file_path) {
            Storage::disk('public')->delete($event->song_file_path);
        }
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Evento eliminado correctamente.');
    }

    public function publish(Request $request, Event $event): RedirectResponse
    {
        $event->update(['is_published' => !$event->is_published]);
        $msg = $event->is_published ? 'Evento publicado.' : 'Evento despublicado.';
        return back()->with('success', $msg);
    }

    public function uploadMedia(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'media_type' => 'required|in:photo_main,photo_second,photo_third,photo_third_2,photo_third_3,photo_third_4,photo_gallery,floral_top_left,floral_bottom_right,floral_envelope,floral_divider,floral_cal_tl,floral_cal_br,seal_closed,seal_open,torn_top,torn_bottom',
            'media_file' => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:5120',
        ]);

        $path = $request->file('media_file')->store(
            "events/{$event->id}/photos", 'public'
        );

        // Replace existing if same type (except gallery)
        if ($request->media_type !== 'photo_gallery') {
            $existing = $event->media()->where('media_type', $request->media_type)->first();
            if ($existing) {
                Storage::disk('public')->delete($existing->file_path);
                $existing->update(['file_path' => $path]);
                return back()->with('success', 'Foto actualizada.');
            }
        }

        EventMedia::create([
            'event_id'   => $event->id,
            'media_type' => $request->media_type,
            'file_path'  => $path,
            'alt_text'   => $event->main_name,
            'sort_order' => $event->media()->max('sort_order') + 1,
        ]);

        return back()->with('success', 'Foto subida correctamente.');
    }

    public function deleteMedia(Event $event, EventMedia $media): RedirectResponse
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return back()->with('success', 'Foto eliminada.');
    }

    public function updateSealInitials(Request $request, Event $event): RedirectResponse
    {
        $request->validate(['seal_initials' => 'nullable|string|max:10']);
        $event->update(['seal_initials' => $request->input('seal_initials') ?: null]);
        return back()->with('success', 'Iniciales del sello guardadas.');
    }

    public function uploadSong(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'song_file' => 'required|mimes:mp3,mpeg,wav|max:20480',
            'song_title'  => 'nullable|string|max:200',
            'song_artist' => 'nullable|string|max:200',
        ]);

        if ($event->song_file_path) {
            Storage::disk('public')->delete($event->song_file_path);
        }

        $path = $request->file('song_file')->store("events/{$event->id}/audio", 'public');

        $event->update([
            'song_file_path' => $path,
            'song_title'     => $request->song_title,
            'song_artist'    => $request->song_artist,
        ]);

        return back()->with('success', 'Canción subida correctamente.');
    }

    private function validateEvent(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'theme_id'           => 'required|exists:themes,id',
            'event_type'         => 'required|in:boda,quinceanera,cumpleanos,aniversario,otro',
            'main_name'          => 'required|string|max:200',
            'second_name'        => 'nullable|string|max:200',
            'event_title_custom' => 'nullable|string|max:300',
            'event_date'         => 'required|date',
            'ceremony_time'      => 'nullable|date_format:H:i,H:i:s',
            'reception_time'     => 'nullable|date_format:H:i,H:i:s',
            'love_message'       => 'nullable|string',
            'bible_verse'        => 'nullable|string',
            'bible_reference'    => 'nullable|string|max:50',
            'show_music_player'  => 'boolean',
            'show_dress_code'    => 'boolean',
            'show_gift_suggestion' => 'boolean',
            'show_recommendations' => 'boolean',
            'show_rsvp'          => 'boolean',
            'show_countdown'     => 'boolean',
            'show_itinerary'     => 'boolean',
            'dress_code_general' => 'nullable|string',
            'dress_code_women'   => 'nullable|string',
            'dress_code_men'     => 'nullable|string',
            'gift_suggestion_text' => 'nullable|string',
            'contact_whatsapp'   => 'nullable|string|max:20',
            'contact_name'       => 'nullable|string|max:100',
            'total_seats'        => 'nullable|integer|min:0',
            'color_primary'      => 'nullable|string|max:20',
            'color_secondary'    => 'nullable|string|max:20',
            'color_accent'       => 'nullable|string|max:20',
            'color_bg'           => 'nullable|string|max:20',
            'color_text'         => 'nullable|string|max:20',
            'color_envelope'     => 'nullable|string|max:20',
            'color_seal'             => 'nullable|string|max:20',
            'general_invite_message' => 'nullable|string|max:200',
        ]);
    }

    private function parseRecommendations(Request $request): ?array
    {
        $icons = $request->input('rec_icons', []);
        $texts = $request->input('rec_texts', []);
        if (empty($texts)) return null;

        $recs = [];
        foreach ($texts as $i => $text) {
            if (!empty($text)) {
                $recs[] = ['icon' => $icons[$i] ?? 'clock', 'text' => $text];
            }
        }
        return empty($recs) ? null : $recs;
    }
}
