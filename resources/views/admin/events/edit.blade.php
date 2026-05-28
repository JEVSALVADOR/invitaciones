@extends('layouts.admin')
@section('title', 'Editar: ' . $event->main_name)

@section('header-actions')
<div class="flex items-center gap-2">
    @if($event->is_published)
    <a href="{{ route('invitation.show', $event->uuid) }}" target="_blank"
       class="inline-flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50">
        👁 Ver invitación
    </a>
    @endif
    <form method="POST" action="{{ route('admin.events.publish', $event) }}">
        @csrf
        <button type="submit"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium text-white"
                style="background-color: {{ $event->is_published ? '#dc2626' : '#16a34a' }}">
            {{ $event->is_published ? '📴 Despublicar' : '🚀 Publicar' }}
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{}">

    <!-- URL de la invitación -->
    @if($event->is_published)
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-blue-800 mb-2">🔗 URL de la invitación</p>
        <div class="flex items-center gap-2">
            <input type="text" readonly
                   value="{{ url('/i/' . $event->uuid) }}"
                   class="flex-1 text-sm bg-white border border-blue-200 rounded-lg px-3 py-2 text-blue-700"
                   id="invitationUrl">
            <button onclick="navigator.clipboard.writeText(document.getElementById('invitationUrl').value).then(()=>alert('¡URL copiada!'))"
                    class="px-3 py-2 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">
                Copiar
            </button>
        </div>
    </div>
    @endif

    <!-- Tabs -->
    <div x-data="{ tab: 'info' }" class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 flex gap-1 overflow-x-auto">
            @foreach(['info' => '📝 Información', 'media' => '📷 Fotos', 'music' => '🎵 Música', 'locations' => '📍 Ubicaciones', 'itinerary' => '📋 Itinerario', 'guests' => '👥 Invitados'] as $key => $label)
            <button @click="tab = '{{ $key }}'"
                    :class="tab === '{{ $key }}' ? 'bg-gray-800 text-white' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2 rounded-lg text-xs font-medium whitespace-nowrap transition-colors">
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- TAB: Información básica -->
        <div x-show="tab === 'info'">
            <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-4">
                @csrf @method('PUT')

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de evento</label>
                            <select name="event_type" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(['quinceanera' => 'XV Años', 'boda' => 'Boda', 'cumpleanos' => 'Cumpleaños', 'aniversario' => 'Aniversario', 'otro' => 'Otro'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $event->event_type === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tema visual</label>
                            <select name="theme_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($themes as $theme)
                                <option value="{{ $theme->id }}" {{ $event->theme_id === $theme->id ? 'selected' : '' }}>{{ $theme->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre principal</label>
                            <input type="text" name="main_name" value="{{ old('main_name', $event->main_name) }}" required
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Segundo nombre</label>
                            <input type="text" name="second_name" value="{{ old('second_name', $event->second_name) }}"
                                   placeholder="Solo para bodas"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del evento</label>
                            <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hora de ceremonia</label>
                            <input type="time" name="ceremony_time" value="{{ old('ceremony_time', $event->ceremony_time) }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp contacto</label>
                            <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $event->contact_whatsapp) }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre contacto</label>
                            <input type="text" name="contact_name" value="{{ old('contact_name', $event->contact_name) }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje descriptivo</label>
                            <textarea name="love_message" rows="4"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('love_message', $event->love_message) }}</textarea>
                        </div>
                        <div class="sm:col-span-2 grid sm:grid-cols-3 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cita bíblica / frase</label>
                                <textarea name="bible_verse" rows="2"
                                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bible_verse', $event->bible_verse) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Referencia</label>
                                <input type="text" name="bible_reference" value="{{ old('bible_reference', $event->bible_reference) }}"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dress Code general</label>
                            <input type="text" name="dress_code_general" value="{{ old('dress_code_general', $event->dress_code_general) }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mujeres</label>
                            <textarea name="dress_code_women" rows="2"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('dress_code_women', $event->dress_code_women) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hombres</label>
                            <textarea name="dress_code_men" rows="2"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('dress_code_men', $event->dress_code_men) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sugerencia de regalos</label>
                            <textarea name="gift_suggestion_text" rows="3"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('gift_suggestion_text', $event->gift_suggestion_text) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- TAB: Fotos -->
        <div x-show="tab === 'media'">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
                @foreach(['photo_main' => 'Foto Principal (Polaroid)', 'photo_second' => 'Segunda Foto (Marco dorado)', 'photo_third' => 'Tercera Foto (Efecto rasgado)'] as $type => $label)
                @php $existing = $event->media->where('media_type', $type)->first(); @endphp
                <div class="flex items-start gap-4 pb-5 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="w-20 h-20 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                        @if($existing)
                        <img src="{{ Storage::url($existing->file_path) }}" class="w-full h-full object-cover" alt="">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-2xl">📷</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700 mb-2">{{ $label }}</p>
                        <form method="POST" action="{{ route('admin.events.media.upload', $event) }}" enctype="multipart/form-data" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="media_type" value="{{ $type }}">
                            <input type="file" name="media_file" accept="image/*" required
                                   class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <button type="submit" class="px-3 py-1.5 rounded text-xs font-medium text-white" style="background-color: #1e3a5f">Subir</button>
                        </form>
                        @if($existing)
                        <form method="POST" action="{{ route('admin.events.media.delete', [$event, $existing]) }}" class="mt-2">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar esta foto?')"
                                    class="text-xs text-red-500 hover:text-red-700">Eliminar foto</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TAB: Música -->
        <div x-show="tab === 'music'">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                @if($event->song_file_path)
                <div class="mb-4 p-3 bg-green-50 rounded-lg border border-green-200 text-sm">
                    <p class="font-medium text-green-800">🎵 Canción actual: {{ $event->song_title ?? 'Sin título' }}</p>
                    @if($event->song_artist) <p class="text-green-600 text-xs">{{ $event->song_artist }}</p> @endif
                    <audio controls class="mt-2 w-full" src="{{ Storage::url($event->song_file_path) }}"></audio>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.events.song.upload', $event) }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Título de la canción</label>
                            <input type="text" name="song_title" value="{{ $event->song_title }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Artista</label>
                            <input type="text" name="song_artist" value="{{ $event->song_artist }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo MP3 <span class="text-gray-400">(máx. 20MB)</span></label>
                        <input type="file" name="song_file" accept=".mp3,audio/mpeg"
                               class="text-sm text-gray-600 file:mr-2 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">
                        Guardar canción
                    </button>
                </form>
            </div>
        </div>

        <!-- TAB: Ubicaciones -->
        <div x-show="tab === 'locations'" x-data="locationsTab({{ $event->id }})">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-medium text-gray-700">Ubicaciones del evento</h3>
                    <button @click="addLocation()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">+ Agregar</button>
                </div>
                <div id="locations-container" class="space-y-3">
                    @foreach($event->locations as $loc)
                    <div class="border border-gray-200 rounded-lg p-4 location-row" data-id="{{ $loc->id }}">
                        <div class="grid sm:grid-cols-2 gap-3">
                            <input type="text" value="{{ $loc->location_type }}" placeholder="Tipo (CEREMONIA, RECEPCIÓN...)" class="border border-gray-200 rounded px-3 py-2 text-sm loc-type">
                            <input type="text" value="{{ $loc->venue_name }}" placeholder="Nombre del lugar" class="border border-gray-200 rounded px-3 py-2 text-sm loc-venue">
                            <textarea class="border border-gray-200 rounded px-3 py-2 text-sm loc-address sm:col-span-2" rows="2" placeholder="Dirección completa">{{ $loc->address }}</textarea>
                            <input type="time" value="{{ $loc->event_time }}" class="border border-gray-200 rounded px-3 py-2 text-sm loc-time">
                            <input type="url" value="{{ $loc->google_maps_url }}" placeholder="URL de Google Maps" class="border border-gray-200 rounded px-3 py-2 text-sm loc-maps">
                        </div>
                        <div class="flex justify-between mt-3">
                            <button type="button" onclick="saveLocation({{ $loc->id }})" class="text-xs px-3 py-1 bg-blue-600 text-white rounded">Guardar</button>
                            <button type="button" onclick="deleteLocation({{ $loc->id }}, this)" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TAB: Itinerario -->
        <div x-show="tab === 'itinerary'">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-medium text-gray-700">Itinerario del evento</h3>
                    <button onclick="addItineraryItem()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">+ Agregar</button>
                </div>
                <div id="itinerary-container" class="space-y-3">
                    @foreach($event->itinerary as $item)
                    <div class="border border-gray-200 rounded-lg p-4" data-id="{{ $item->id }}">
                        <div class="grid sm:grid-cols-3 gap-3">
                            <input type="text" value="{{ $item->time_label }}" placeholder="4:00 PM" class="border border-gray-200 rounded px-3 py-2 text-sm item-time-label">
                            <input type="time" value="{{ $item->event_time }}" class="border border-gray-200 rounded px-3 py-2 text-sm item-time">
                            <input type="text" value="{{ $item->activity_name }}" placeholder="CEREMONIA, VALS..." class="border border-gray-200 rounded px-3 py-2 text-sm item-activity">
                            <select class="border border-gray-200 rounded px-3 py-2 text-sm item-icon">
                                @foreach(['church' => 'Iglesia', 'camera' => 'Cámara', 'reception_table' => 'Mesa', 'cake' => 'Pastel', 'dance' => 'Baile', 'dinner' => 'Cena', 'party' => 'Fiesta', 'toast' => 'Brindis', 'car' => 'Auto', 'ring' => 'Anillo'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $item->icon_type === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                            <select class="border border-gray-200 rounded px-3 py-2 text-sm item-position">
                                <option value="right" {{ $item->position === 'right' ? 'selected' : '' }}>Derecha</option>
                                <option value="left" {{ $item->position === 'left' ? 'selected' : '' }}>Izquierda</option>
                            </select>
                        </div>
                        <div class="flex justify-between mt-3">
                            <button type="button" onclick="saveItineraryItem({{ $item->id }}, this)" class="text-xs px-3 py-1 bg-blue-600 text-white rounded">Guardar</button>
                            <button type="button" onclick="deleteItineraryItem({{ $item->id }}, this)" class="text-xs text-red-500">Eliminar</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TAB: Invitados -->
        <div x-show="tab === 'guests'">
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm text-gray-600">{{ $event->guests->count() }} invitados registrados</p>
                <a href="{{ route('admin.events.guests.create', $event) }}"
                   class="inline-flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-medium text-white"
                   style="background-color: #1e3a5f">
                    + Agregar invitado
                </a>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Nombre</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">Asientos</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden lg:table-cell">URL Personalizada</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($event->guests as $guest)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $guest->guest_name }}</td>
                            <td class="px-4 py-3 hidden md:table-cell text-gray-600">{{ $guest->seats_reserved }}</td>
                            <td class="px-4 py-3 hidden lg:table-cell">
                                @if($guest->guest_slug)
                                <code class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600">
                                    /i/{{ $event->uuid }}/{{ $guest->guest_slug }}
                                </code>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    @if($guest->guest_slug)
                                    <button onclick="navigator.clipboard.writeText('{{ url('/i/'.$event->uuid.'/'.$guest->guest_slug) }}').then(()=>alert('URL copiada'))"
                                            class="text-xs text-gray-400 hover:text-gray-600" title="Copiar URL">📋</button>
                                    @endif
                                    <a href="{{ route('admin.guests.edit', $guest) }}" class="text-blue-500 hover:text-blue-700 text-xs">Editar</a>
                                    <form method="POST" action="{{ route('admin.guests.destroy', $guest) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar invitado?')" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">No hay invitados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
const eventId = {{ $event->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

async function apiPost(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
    });
    return res.json();
}

async function saveLocation(id) {
    const row = document.querySelector(`[data-id="${id}"]`);
    const data = {
        _method: 'PUT',
        location_type: row.querySelector('.loc-type').value,
        venue_name: row.querySelector('.loc-venue').value,
        address: row.querySelector('.loc-address').value,
        event_time: row.querySelector('.loc-time').value,
        google_maps_url: row.querySelector('.loc-maps').value,
    };
    const res = await fetch(`/admin/locations/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
    });
    if (res.ok) { alert('Ubicación guardada'); } else { alert('Error al guardar'); }
}

async function deleteLocation(id, btn) {
    if (!confirm('¿Eliminar ubicación?')) return;
    const res = await fetch(`/admin/locations/${id}`, {
        method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken }
    });
    if (res.ok) btn.closest('.location-row').remove();
}

function addLocation() {
    alert('Use el botón de guardar en una nueva fila — CRUD de ubicaciones vía API (implementar endpoint).');
}

async function saveItineraryItem(id, btn) {
    const row = btn.closest('[data-id]');
    const data = {
        _method: 'PUT',
        time_label: row.querySelector('.item-time-label').value,
        event_time: row.querySelector('.item-time').value,
        activity_name: row.querySelector('.item-activity').value,
        icon_type: row.querySelector('.item-icon').value,
        position: row.querySelector('.item-position').value,
    };
    const res = await fetch(`/admin/itinerary/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
    });
    if (res.ok) { btn.textContent = '✓ Guardado'; setTimeout(()=>{ btn.textContent='Guardar'; },2000); }
}

async function deleteItineraryItem(id, btn) {
    if (!confirm('¿Eliminar item?')) return;
    const res = await fetch(`/admin/itinerary/${id}`, {
        method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken }
    });
    if (res.ok) btn.closest('[data-id]').remove();
}
</script>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
