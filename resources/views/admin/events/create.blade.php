@extends('layouts.admin')
@section('title', 'Crear Evento')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-6">
        @csrf

        <!-- Info básica -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Información Básica</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de evento *</label>
                    <select name="event_type" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccionar...</option>
                        <option value="quinceanera">XV Años / Quinceañera</option>
                        <option value="boda">Boda</option>
                        <option value="cumpleanos">Cumpleaños</option>
                        <option value="aniversario">Aniversario</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tema visual *</label>
                    <select name="theme_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($themes as $theme)
                        <option value="{{ $theme->id }}" style="color: {{ $theme->primary_color }}">{{ $theme->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre principal *</label>
                    <input type="text" name="main_name" value="{{ old('main_name') }}" required
                           placeholder="Nombre de la festejada / Novia"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Segundo nombre <span class="text-gray-400">(solo bodas)</span></label>
                    <input type="text" name="second_name" value="{{ old('second_name') }}"
                           placeholder="Nombre del novio"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del evento *</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora de ceremonia</label>
                    <input type="time" name="ceremony_time" value="{{ old('ceremony_time') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp de contacto</label>
                    <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp') }}"
                           placeholder="+52 33 1234 5678"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del contacto</label>
                    <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                           placeholder="Ej: Mamá de Sofía"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Texto y mensaje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Mensajes</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje de amor / descripción</label>
                    <textarea name="love_message" rows="4" placeholder="Descripción emotiva del evento..."
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('love_message') }}</textarea>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cita bíblica o frase especial</label>
                        <textarea name="bible_verse" rows="3" placeholder="Texto de la cita..."
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bible_verse') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Referencia</label>
                        <input type="text" name="bible_reference" value="{{ old('bible_reference') }}"
                               placeholder="Ej: Juan 3:16"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Dress Code -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Dress Code</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código general</label>
                    <input type="text" name="dress_code_general" value="{{ old('dress_code_general') }}"
                           placeholder="Ej: Formal / Coctel"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mujeres</label>
                        <textarea name="dress_code_women" rows="2" placeholder="Indicaciones para mujeres..."
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('dress_code_women') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hombres</label>
                        <textarea name="dress_code_men" rows="2" placeholder="Indicaciones para hombres..."
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('dress_code_men') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Regalos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Sugerencia de Regalos</h2>
            <textarea name="gift_suggestion_text" rows="3" placeholder="Texto sobre el regalo esperado..."
                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('gift_suggestion_text') }}</textarea>
        </div>

        <!-- Recomendaciones -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ recs: [{ icon: 'children', text: '' }] }">
            <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Recomendaciones</h2>

            <template x-for="(rec, idx) in recs" :key="idx">
                <div class="flex items-start gap-3 mb-3">
                    <select :name="'rec_icons[' + idx + ']'" class="border border-gray-200 rounded-lg px-2 py-2.5 text-sm focus:outline-none">
                        <option value="children">👶 Niños</option>
                        <option value="phone">📱 Teléfono</option>
                        <option value="clock">🕐 Puntualidad</option>
                        <option value="car">🚗 Estacionamiento</option>
                        <option value="camera">📷 Fotos</option>
                    </select>
                    <input type="text" :name="'rec_texts[' + idx + ']'" x-model="rec.text"
                           placeholder="Texto de la recomendación..."
                           class="flex-1 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" @click="recs.splice(idx, 1)"
                            class="text-red-400 hover:text-red-600 mt-2.5">✕</button>
                </div>
            </template>

            <button type="button" @click="recs.push({ icon: 'clock', text: '' })"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                + Agregar recomendación
            </button>
        </div>

        <!-- Secciones visibles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Secciones visibles</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach(['show_music_player' => '🎵 Reproductor', 'show_countdown' => '⏱ Contador', 'show_itinerary' => '📋 Itinerario', 'show_dress_code' => '👗 Dress Code', 'show_gift_suggestion' => '🎁 Regalos', 'show_recommendations' => '📌 Recomendaciones', 'show_rsvp' => '✉️ RSVP'] as $field => $label)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="{{ $field }}" value="1" checked
                           class="w-4 h-4 rounded" style="accent-color: #1e3a5f">
                    <span class="text-sm text-gray-700">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.events.index') }}"
               class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-lg text-sm font-medium text-white"
                    style="background-color: #1e3a5f">
                Crear Evento
            </button>
        </div>
    </form>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
