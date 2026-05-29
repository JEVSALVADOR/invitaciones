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
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Mensaje invitación general
                                <span class="text-xs text-gray-400 font-normal ml-1">— visible solo en el enlace general (sin nombre de invitado)</span>
                            </label>
                            <input type="text" name="general_invite_message"
                                   value="{{ old('general_invite_message', $event->general_invite_message) }}"
                                   placeholder="ej: Hemos reservado un lugar para ti"
                                   maxlength="200"
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

                <!-- Recomendaciones -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6"
                     x-data="{ recs: {{ json_encode($event->recommendations ?? [['icon'=>'children','text'=>'']]) }} }">
                    <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Recomendaciones</h2>
                    <template x-for="(rec, idx) in recs" :key="idx">
                        <div class="flex items-start gap-3 mb-3">
                            <select :name="'rec_icons[' + idx + ']'" x-model="rec.icon"
                                    class="border border-gray-200 rounded-lg px-2 py-2.5 text-sm focus:outline-none">
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

                <!-- Paleta de colores -->
                @php
                    $colorFields = [
                        'color_primary'   => ['label' => 'Color principal',   'desc' => 'Sobre, botones, footer, countdown',       'theme' => $event->theme->primary_color],
                        'color_secondary' => ['label' => 'Color secundario',  'desc' => 'Acento decorativo secundario',             'theme' => $event->theme->secondary_color],
                        'color_accent'    => ['label' => 'Color de acento',   'desc' => 'Letras en script, bordes dorados, iconos', 'theme' => $event->theme->accent_color],
                        'color_bg'        => ['label' => 'Color de fondo',    'desc' => 'Fondo principal de la invitación',         'theme' => $event->theme->background_color],
                        'color_text'      => ['label' => 'Color de texto',    'desc' => 'Texto general del cuerpo',                 'theme' => $event->theme->text_color],
                        'color_envelope'  => ['label' => 'Color del sobre',   'desc' => 'Interior y exterior del sobre',            'theme' => $event->theme->envelope_color],
                        'color_seal'      => ['label' => 'Color del sello',   'desc' => 'Sello de cera (wax seal)',                 'theme' => $event->theme->seal_color],
                    ];
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5 pb-2 border-b border-gray-100">
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Paleta de colores</h2>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Sobreescribe los colores del tema para este evento. Deja el campo vacío para usar el color del tema.
                            </p>
                        </div>
                        <button type="button" onclick="paletteResetAll()"
                                class="text-xs text-red-400 hover:text-red-600 font-medium">
                            Restablecer todo
                        </button>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($colorFields as $field => $meta)
                        @php $val = old($field, $event->$field ?? ''); @endphp
                        <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 bg-gray-50">

                            {{-- Color picker visual (no name, solo actualiza el text input) --}}
                            <input type="color"
                                   id="picker_{{ $field }}"
                                   value="{{ $val ?: $meta['theme'] }}"
                                   data-default="{{ $meta['theme'] }}"
                                   oninput="palettePickerChange('{{ $field }}', this.value)"
                                   class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-0.5 bg-white flex-shrink-0"
                                   title="Elegir color">

                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-700">{{ $meta['label'] }}</p>
                                <p class="text-xs text-gray-400 mb-1">{{ $meta['desc'] }}</p>
                                <div class="flex items-center gap-1">
                                    {{-- Este input SÍ tiene name y es el que envía el formulario --}}
                                    <input type="text"
                                           name="{{ $field }}"
                                           id="txt_{{ $field }}"
                                           value="{{ $val }}"
                                           placeholder="← del tema"
                                           maxlength="20"
                                           oninput="paletteTxtChange('{{ $field }}', this.value)"
                                           class="w-28 text-xs border border-gray-200 rounded px-2 py-1 font-mono focus:outline-none focus:ring-1 focus:ring-blue-400 bg-white">
                                    <button type="button"
                                            onclick="paletteClear('{{ $field }}')"
                                            class="text-gray-300 hover:text-red-400 text-xs leading-none" title="Quitar color personalizado">✕</button>
                                </div>
                                <p class="text-xs mt-1" id="lbl_{{ $field }}">
                                    @if($val)
                                        <span class="text-emerald-600 font-medium">color personalizado</span>
                                    @else
                                        <span class="text-gray-300">usando tema</span>
                                    @endif
                                </p>
                            </div>

                            {{-- Preview swatch --}}
                            <div id="swatch_{{ $field }}"
                                 class="w-7 h-7 flex-shrink-0 rounded-full border border-gray-200 shadow-sm"
                                 style="background: {{ $val ?: $meta['theme'] }}"></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <script>
                function palettePickerChange(field, value) {
                    document.getElementById('txt_' + field).value = value;
                    document.getElementById('swatch_' + field).style.background = value;
                    document.getElementById('lbl_' + field).innerHTML = '<span class="text-emerald-600 font-medium">color personalizado</span>';
                }
                function paletteTxtChange(field, value) {
                    var swatch = document.getElementById('swatch_' + field);
                    var picker = document.getElementById('picker_' + field);
                    var lbl    = document.getElementById('lbl_' + field);
                    if (/^#[0-9A-Fa-f]{3}([0-9A-Fa-f]{3})?$/.test(value)) {
                        picker.value = value;
                        swatch.style.background = value;
                        lbl.innerHTML = '<span class="text-emerald-600 font-medium">color personalizado</span>';
                    } else {
                        swatch.style.background = value || picker.dataset.default;
                        lbl.innerHTML = value ? '<span class="text-amber-500">hex inválido</span>' : '<span class="text-gray-300">usando tema</span>';
                    }
                }
                function paletteClear(field) {
                    var def = document.getElementById('picker_' + field).dataset.default;
                    document.getElementById('txt_' + field).value = '';
                    document.getElementById('picker_' + field).value = def;
                    document.getElementById('swatch_' + field).style.background = def;
                    document.getElementById('lbl_' + field).innerHTML = '<span class="text-gray-300">usando tema</span>';
                }
                function paletteResetAll() {
                    ['color_primary','color_secondary','color_accent','color_bg','color_text','color_envelope','color_seal']
                        .forEach(function(f){ paletteClear(f); });
                }
                </script>

                <!-- Secciones visibles -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">Secciones visibles</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach(['show_music_player' => '🎵 Reproductor', 'show_countdown' => '⏱ Contador', 'show_itinerary' => '📋 Itinerario', 'show_dress_code' => '👗 Dress Code', 'show_gift_suggestion' => '🎁 Regalos', 'show_recommendations' => '📌 Recomendaciones', 'show_rsvp' => '✉️ RSVP'] as $field => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="{{ $field }}" value="1"
                                   {{ old($field, $event->$field) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded" style="accent-color: #1e3a5f">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
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
        <div x-show="tab === 'media'" class="space-y-4">

            <!-- Fotos del evento -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
                <h2 class="text-base font-semibold text-gray-800 pb-2 border-b border-gray-100">Fotos del evento</h2>
                @foreach(['photo_main' => 'Foto Principal (Polaroid)', 'photo_second' => 'Segunda Foto (Marco dorado)'] as $type => $label)
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

            <!-- Fotos sección rasgada (slideshow) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5 pb-2 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Sección rasgada — Fotos del carrusel</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Sube entre 1 y 4 fotos. Con 1 foto se muestra estática; con 2 o más se activa un carrusel con transición de difuminado elegante.
                    </p>
                </div>
                @php
                    $tornSlots = [
                        'photo_third'   => ['label' => 'Foto 1 (principal)', 'relation' => 'thirdPhoto'],
                        'photo_third_2' => ['label' => 'Foto 2',             'relation' => 'thirdPhoto2'],
                        'photo_third_3' => ['label' => 'Foto 3',             'relation' => 'thirdPhoto3'],
                        'photo_third_4' => ['label' => 'Foto 4',             'relation' => 'thirdPhoto4'],
                    ];
                @endphp
                <div class="space-y-5">
                    @foreach($tornSlots as $type => $meta)
                    @php $existing = $event->{$meta['relation']}; @endphp
                    <div class="flex items-start gap-4 pb-5 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="w-20 h-20 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                            @if($existing)
                            <img src="{{ Storage::url($existing->file_path) }}" class="w-full h-full object-cover" alt="">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 text-2xl">📷</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 mb-1">{{ $meta['label'] }}</p>
                            @if($existing)
                            <p class="text-xs text-emerald-600 font-medium mb-2">Foto cargada</p>
                            @else
                            <p class="text-xs text-gray-400 mb-2">Sin foto</p>
                            @endif
                            <form method="POST" action="{{ route('admin.events.media.upload', $event) }}" enctype="multipart/form-data" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="media_type" value="{{ $type }}">
                                <input type="file" name="media_file" accept="image/*" required
                                       class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <button type="submit" class="px-3 py-1.5 rounded text-xs font-medium text-white" style="background-color: #1e3a5f">
                                    {{ $existing ? 'Reemplazar' : 'Subir' }}
                                </button>
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

            <!-- Overlays florales de portada -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5 pb-2 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Overlays florales de portada</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Imágenes PNG con fondo transparente que reemplazan los adornos SVG generados en la portada de la invitación.
                        Si no se sube una imagen se usará el SVG del tema por defecto.
                    </p>
                </div>

                @php
                    $floralItems = [
                        'floral_top_left'    => ['label' => 'Flores esquina superior izquierda', 'desc' => 'Aparece en la esquina superior izquierda de la portada', 'relation' => 'floralTopLeft'],
                        'floral_bottom_right'=> ['label' => 'Flores esquina inferior derecha',   'desc' => 'Aparece en la esquina inferior derecha de la portada',  'relation' => 'floralBottomRight'],
                        'floral_envelope'    => ['label' => 'Flores sobre (envelope overlay)',    'desc' => 'Se superpone encima del sobre en la portada',           'relation' => 'floralEnvelope'],
                    ];
                @endphp

                <div class="space-y-5">
                    @foreach($floralItems as $type => $meta)
                    @php $existing = $event->{$meta['relation']}; @endphp
                    <div class="flex items-start gap-4 pb-5 border-b border-gray-100 last:border-0 last:pb-0">

                        <!-- Miniatura / Preview -->
                        <div class="w-24 h-24 rounded-xl border border-dashed border-gray-200 bg-gray-50 flex-shrink-0 overflow-hidden flex items-center justify-center relative"
                             style="background-image: linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%),linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%);background-size:12px 12px;background-position:0 0,6px 6px;">
                            @if($existing)
                            <img src="{{ Storage::url($existing->file_path) }}"
                                 class="w-full h-full object-contain" alt="{{ $meta['label'] }}">
                            @else
                            <span class="text-3xl select-none">🌸</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800">{{ $meta['label'] }}</p>
                            <p class="text-xs text-gray-400 mb-3">{{ $meta['desc'] }}</p>

                            <form method="POST" action="{{ route('admin.events.media.upload', $event) }}"
                                  enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                @csrf
                                <input type="hidden" name="media_type" value="{{ $type }}">
                                <input type="file" name="media_file" accept=".png,.PNG,image/png" required
                                       class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-medium text-white"
                                        style="background-color: #1e3a5f">
                                    {{ $existing ? 'Reemplazar' : 'Subir PNG' }}
                                </button>
                            </form>

                            @if($existing)
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs text-emerald-600 font-medium">PNG personalizado activo</span>
                                <form method="POST"
                                      action="{{ route('admin.events.media.delete', [$event, $existing]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar este overlay y volver al SVG del tema?')"
                                            class="text-xs text-red-500 hover:text-red-700">
                                        Eliminar y usar SVG
                                    </button>
                                </form>
                            </div>
                            @else
                            <p class="text-xs text-gray-400 mt-1">Usando SVG del tema por defecto</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Overlays florales interiores -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5 pb-2 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Overlays florales interiores</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Adornos PNG que aparecen dentro de la invitación (tras abrir el sobre).
                        Si no se sube una imagen se usará el SVG del tema por defecto.
                    </p>
                </div>

                @php
                    $innerFloralItems = [
                        'floral_divider' => ['label' => 'Divisor floral entre secciones', 'desc' => 'Separador decorativo entre la sección del sobre abierto y el calendario', 'relation' => 'floralDivider'],
                        'floral_cal_tl'  => ['label' => 'Floral calendario — esquina superior izquierda', 'desc' => 'Adorno en la esquina superior izquierda del calendario "Reserva la fecha"', 'relation' => 'floralCalTl'],
                        'floral_cal_br'  => ['label' => 'Floral calendario — esquina inferior derecha',  'desc' => 'Adorno en la esquina inferior derecha del calendario "Reserva la fecha"',  'relation' => 'floralCalBr'],
                    ];
                @endphp

                <div class="space-y-5">
                    @foreach($innerFloralItems as $type => $meta)
                    @php $existing = $event->{$meta['relation']}; @endphp
                    <div class="flex items-start gap-4 pb-5 border-b border-gray-100 last:border-0 last:pb-0">

                        <!-- Miniatura con fondo ajedrezado para ver transparencia -->
                        <div class="w-24 h-24 rounded-xl border border-dashed border-gray-200 bg-gray-50 flex-shrink-0 overflow-hidden flex items-center justify-center"
                             style="background-image: linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%),linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%);background-size:12px 12px;background-position:0 0,6px 6px;">
                            @if($existing)
                            <img src="{{ Storage::url($existing->file_path) }}"
                                 class="w-full h-full object-contain" alt="{{ $meta['label'] }}">
                            @else
                            <span class="text-3xl select-none">🌿</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800">{{ $meta['label'] }}</p>
                            <p class="text-xs text-gray-400 mb-3">{{ $meta['desc'] }}</p>

                            <form method="POST" action="{{ route('admin.events.media.upload', $event) }}"
                                  enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                @csrf
                                <input type="hidden" name="media_type" value="{{ $type }}">
                                <input type="file" name="media_file" accept=".png,.PNG,image/png" required
                                       class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-medium text-white"
                                        style="background-color: #1e3a5f">
                                    {{ $existing ? 'Reemplazar' : 'Subir PNG' }}
                                </button>
                            </form>

                            @if($existing)
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs text-emerald-600 font-medium">PNG personalizado activo</span>
                                <form method="POST"
                                      action="{{ route('admin.events.media.delete', [$event, $existing]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar este overlay y volver al SVG del tema?')"
                                            class="text-xs text-red-500 hover:text-red-700">
                                        Eliminar y usar SVG
                                    </button>
                                </form>
                            </div>
                            @else
                            <p class="text-xs text-gray-400 mt-1">Usando SVG del tema por defecto</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Sellos de la carta (wax seal) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-5 pb-3 border-b border-gray-100">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base font-semibold text-gray-800">Sello de la carta</h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Imagen PNG circular (fondo transparente) que reemplaza el sello de cera.
                            Las iniciales se muestran encima del sello tanto en la carta cerrada como abierta.
                        </p>
                    </div>

                    {{-- Iniciales del sello --}}
                    <form method="POST" action="{{ route('admin.events.seal.initials', $event) }}"
                          class="flex items-end gap-2 flex-shrink-0">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Iniciales del sello
                                @if($event->seal_initials)
                                <span class="text-amber-600 font-medium ml-1">— "{{ $event->seal_initials }}"</span>
                                @endif
                            </label>
                            <input type="text"
                                   name="seal_initials"
                                   value="{{ old('seal_initials', $event->seal_initials ?? '') }}"
                                   placeholder="ej: MV"
                                   maxlength="10"
                                   class="w-24 text-sm border border-gray-200 rounded-lg px-3 py-2 text-center font-serif tracking-widest focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <button type="submit"
                                class="px-3 py-2 rounded-lg text-xs font-medium text-white flex-shrink-0"
                                style="background-color: #c9a84c">
                            Guardar
                        </button>
                        @if($event->seal_initials)
                        <a href="{{ route('admin.events.seal.initials', $event) }}"
                           onclick="event.preventDefault();this.closest('form').querySelector('[name=seal_initials]').value='';this.closest('form').submit();"
                           class="text-xs text-red-400 hover:text-red-600 self-center">Quitar</a>
                        @endif
                    </form>
                </div>

                @php
                    $sealItems = [
                        'seal_closed' => [
                            'label'    => 'Sello — carta cerrada',
                            'desc'     => 'Aparece sobre el sobre cerrado en la portada',
                            'relation' => 'sealClosed',
                            'emoji'    => '🔒',
                        ],
                        'seal_open' => [
                            'label'    => 'Sello — carta abierta',
                            'desc'     => 'Aparece en la tarjeta oval y en la sección RSVP',
                            'relation' => 'sealOpen',
                            'emoji'    => '💌',
                        ],
                    ];
                @endphp

                <div class="space-y-5">
                    @foreach($sealItems as $type => $meta)
                    @php $existing = $event->{$meta['relation']}; @endphp
                    <div class="flex items-start gap-4 pb-5 border-b border-gray-100 last:border-0 last:pb-0">

                        <!-- Miniatura circular con fondo ajedrezado -->
                        <div class="w-20 h-20 rounded-full border-2 border-dashed border-gray-200 flex-shrink-0 overflow-hidden flex items-center justify-center"
                             style="background-image:linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%),linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%);background-size:10px 10px;background-position:0 0,5px 5px;">
                            @if($existing)
                            <img src="{{ Storage::url($existing->file_path) }}"
                                 class="w-full h-full object-contain" alt="{{ $meta['label'] }}" style="border-radius:50%;">
                            @else
                            <span class="text-2xl select-none">{{ $meta['emoji'] }}</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800">{{ $meta['label'] }}</p>
                            <p class="text-xs text-gray-400 mb-3">{{ $meta['desc'] }}</p>

                            <form method="POST" action="{{ route('admin.events.media.upload', $event) }}"
                                  enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                @csrf
                                <input type="hidden" name="media_type" value="{{ $type }}">
                                <input type="file" name="media_file" accept=".png,.PNG,image/png" required
                                       class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-medium text-white"
                                        style="background-color: #1e3a5f">
                                    {{ $existing ? 'Reemplazar' : 'Subir PNG' }}
                                </button>
                            </form>

                            @if($existing)
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs text-amber-600 font-medium">PNG personalizado activo</span>
                                <form method="POST"
                                      action="{{ route('admin.events.media.delete', [$event, $existing]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar este sello y volver al estilo por defecto?')"
                                            class="text-xs text-red-500 hover:text-red-700">
                                        Eliminar y usar estilo CSS
                                    </button>
                                </form>
                            </div>
                            @else
                            <p class="text-xs text-gray-400 mt-1">Usando sello CSS por defecto</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bordes rasgados (tercera foto) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5 pb-2 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Bordes rasgados — Tercera foto</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Imágenes PNG (con transparencia) que reemplazan el efecto SVG de papel rasgado sobre la tercera foto.
                        Sube una imagen para el borde superior y otra para el inferior.
                    </p>
                </div>

                @php
                    $tornItems = [
                        'torn_top'    => ['label' => 'Borde rasgado superior', 'desc' => 'Se superpone en la parte superior de la foto', 'relation' => 'tornTop',    'emoji' => '⬆️'],
                        'torn_bottom' => ['label' => 'Borde rasgado inferior', 'desc' => 'Se superpone en la parte inferior de la foto', 'relation' => 'tornBottom', 'emoji' => '⬇️'],
                    ];
                @endphp

                <div class="space-y-5">
                    @foreach($tornItems as $type => $meta)
                    @php $existing = $event->{$meta['relation']}; @endphp
                    <div class="flex items-start gap-4 pb-5 border-b border-gray-100 last:border-0 last:pb-0">

                        {{-- Preview --}}
                        <div class="w-24 h-14 rounded-lg border border-dashed border-gray-200 flex-shrink-0 overflow-hidden flex items-center justify-center"
                             style="background-image:linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%),linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%);background-size:10px 10px;background-position:0 0,5px 5px;">
                            @if($existing)
                                <img src="{{ Storage::url($existing->file_path) }}"
                                     class="w-full h-full object-fill" alt="{{ $meta['label'] }}">
                            @else
                                <span class="text-xl select-none">{{ $meta['emoji'] }}</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800">{{ $meta['label'] }}</p>
                            <p class="text-xs text-gray-400 mb-3">{{ $meta['desc'] }}</p>

                            <form method="POST" action="{{ route('admin.events.media.upload', $event) }}"
                                  enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                @csrf
                                <input type="hidden" name="media_type" value="{{ $type }}">
                                <input type="file" name="media_file" accept=".png,.PNG,image/png" required
                                       class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                                <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-medium text-white"
                                        style="background-color: #1e3a5f">
                                    {{ $existing ? 'Reemplazar' : 'Subir PNG' }}
                                </button>
                            </form>

                            @if($existing)
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs text-violet-600 font-medium">PNG personalizado activo</span>
                                <form method="POST"
                                      action="{{ route('admin.events.media.delete', [$event, $existing]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar este borde y volver al SVG por defecto?')"
                                            class="text-xs text-red-500 hover:text-red-700">
                                        Eliminar y usar SVG
                                    </button>
                                </form>
                            </div>
                            @else
                            <p class="text-xs text-gray-400 mt-1">Usando efecto SVG por defecto</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
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
                            <input type="text" value="{{ $loc->city }}" placeholder="Ciudad" class="border border-gray-200 rounded px-3 py-2 text-sm loc-city">
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
                        {{-- Ícono personalizado --}}
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-3">
                            <div class="item-icon-preview w-11 h-11 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center border border-gray-200">
                                @if($item->icon_image)
                                <img src="{{ Storage::url($item->icon_image) }}" class="w-full h-full object-contain p-1" alt="">
                                @else
                                <svg class="w-5 h-5 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Ícono personalizado <span class="font-normal text-gray-400">(reemplaza el ícono del selector)</span></p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <input type="file" accept="image/*" class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-medium file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 item-icon-file">
                                    <button type="button" onclick="uploadItineraryIcon({{ $item->id }}, this)"
                                            class="px-2.5 py-1 rounded text-xs font-medium text-white bg-violet-600 hover:bg-violet-700">Subir</button>
                                    @if($item->icon_image)
                                    <button type="button" onclick="deleteItineraryIcon({{ $item->id }}, this)"
                                            class="text-xs text-red-400 hover:text-red-600 item-icon-del-btn">Quitar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-3 pt-2">
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

<!-- Modal de confirmación personalizado -->
<div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-[fadeInUp_0.2s_ease]">
        <div class="flex items-center justify-center w-14 h-14 mx-auto mb-4 rounded-full bg-red-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"></path>
                <path d="M10 11v6M14 11v6"></path>
                <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"></path>
            </svg>
        </div>
        <h3 id="confirmModalTitle" class="text-base font-semibold text-gray-800 mb-1"></h3>
        <p id="confirmModalMessage" class="text-sm text-gray-500 mb-6"></p>
        <div class="flex gap-3">
            <button onclick="closeConfirmModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                Cancelar
            </button>
            <button id="confirmModalBtn"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium text-white bg-red-500 hover:bg-red-600 transition-colors">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
const eventId = {{ $event->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let _confirmCallback = null;

function customConfirm(title, message, onConfirm) {
    document.getElementById('confirmModalTitle').textContent   = title;
    document.getElementById('confirmModalMessage').textContent = message;
    _confirmCallback = onConfirm;
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('confirmModalBtn').onclick = () => {
        closeConfirmModal();
        onConfirm();
    };
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    _confirmCallback = null;
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeConfirmModal();
});

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
    const btn = row.querySelector('button');
    const data = {
        location_type:   row.querySelector('.loc-type').value,
        venue_name:      row.querySelector('.loc-venue').value,
        address:         row.querySelector('.loc-address').value,
        city:            row.querySelector('.loc-city').value || null,
        event_time:      row.querySelector('.loc-time').value || null,
        google_maps_url: row.querySelector('.loc-maps').value || null,
    };
    const res = await fetch(`/admin/locations/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
    });
    if (res.ok) {
        btn.textContent = '✓ Guardado';
        setTimeout(() => { btn.textContent = 'Guardar'; }, 2000);
    } else {
        btn.textContent = '✗ Error';
        setTimeout(() => { btn.textContent = 'Guardar'; }, 2000);
    }
}

async function deleteLocation(id, btn) {
    if (!confirm('¿Eliminar ubicación?')) return;
    const res = await fetch(`/admin/locations/${id}`, {
        method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken }
    });
    if (res.ok) btn.closest('.location-row').remove();
}

async function addLocation() {
    const res = await apiPost('/admin/locations', {
        event_id:        eventId,
        location_type:   'NUEVA UBICACIÓN',
        venue_name:      null,
        address:         null,
        city:            null,
        event_time:      null,
        google_maps_url: null,
    });
    if (!res.success) { console.error('Error al crear ubicación'); return; }
    const html = `
    <div class="border border-gray-200 rounded-lg p-4 location-row" data-id="${res.id}">
        <div class="grid sm:grid-cols-2 gap-3">
            <input type="text" value="NUEVA UBICACIÓN" placeholder="Tipo (CEREMONIA, RECEPCIÓN...)" class="border border-gray-200 rounded px-3 py-2 text-sm loc-type">
            <input type="text" value="" placeholder="Nombre del lugar" class="border border-gray-200 rounded px-3 py-2 text-sm loc-venue">
            <textarea class="border border-gray-200 rounded px-3 py-2 text-sm loc-address sm:col-span-2" rows="2" placeholder="Dirección completa"></textarea>
            <input type="text" value="" placeholder="Ciudad" class="border border-gray-200 rounded px-3 py-2 text-sm loc-city">
            <input type="time" value="" class="border border-gray-200 rounded px-3 py-2 text-sm loc-time">
            <input type="url" value="" placeholder="URL de Google Maps" class="border border-gray-200 rounded px-3 py-2 text-sm loc-maps">
        </div>
        <div class="flex justify-between mt-3">
            <button type="button" onclick="saveLocation(${res.id})" class="text-xs px-3 py-1 bg-blue-600 text-white rounded">Guardar</button>
            <button type="button" onclick="deleteLocation(${res.id}, this)" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
        </div>
    </div>`;
    document.getElementById('locations-container').insertAdjacentHTML('beforeend', html);
}

async function saveItineraryItem(id, btn) {
    const row = btn.closest('[data-id]');
    const data = {
        time_label:    row.querySelector('.item-time-label').value,
        event_time:    row.querySelector('.item-time').value || null,
        activity_name: row.querySelector('.item-activity').value,
        icon_type:     row.querySelector('.item-icon').value,
        position:      row.querySelector('.item-position').value,
    };
    const res = await fetch(`/admin/itinerary/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
    });
    if (res.ok) { btn.textContent = '✓ Guardado'; setTimeout(()=>{ btn.textContent='Guardar'; },2000); }
}

function deleteItineraryItem(id, btn) {
    customConfirm(
        '¿Eliminar este item?',
        'Esta acción no se puede deshacer. El item será eliminado permanentemente del itinerario.',
        async () => {
            const res = await fetch(`/admin/itinerary/${id}`, {
                method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) btn.closest('[data-id]').remove();
        }
    );
}

async function addItineraryItem() {
    const res = await apiPost('/admin/itinerary', {
        event_id:      eventId,
        time_label:    '',
        event_time:    '12:00',
        activity_name: 'Nueva actividad',
        icon_type:     'party',
        position:      'right',
    });
    if (!res.success) { alert('Error al crear item'); return; }
    const iconOpts = {church:'Iglesia',camera:'Cámara',reception_table:'Mesa',cake:'Pastel',dance:'Baile',dinner:'Cena',party:'Fiesta',toast:'Brindis',car:'Auto',ring:'Anillo'};
    const options  = Object.entries(iconOpts).map(([v,l]) => `<option value="${v}"${v==='party'?' selected':''}>${l}</option>`).join('');
    const placeholderSvg = `<svg class="w-5 h-5 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>`;
    const html = `
    <div class="border border-gray-200 rounded-lg p-4" data-id="${res.id}">
        <div class="grid sm:grid-cols-3 gap-3">
            <input type="text" value="" placeholder="4:00 PM" class="border border-gray-200 rounded px-3 py-2 text-sm item-time-label">
            <input type="time" value="12:00" class="border border-gray-200 rounded px-3 py-2 text-sm item-time">
            <input type="text" value="Nueva actividad" placeholder="CEREMONIA, VALS..." class="border border-gray-200 rounded px-3 py-2 text-sm item-activity">
            <select class="border border-gray-200 rounded px-3 py-2 text-sm item-icon">${options}</select>
            <select class="border border-gray-200 rounded px-3 py-2 text-sm item-position">
                <option value="right" selected>Derecha</option>
                <option value="left">Izquierda</option>
            </select>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-3">
            <div class="item-icon-preview w-11 h-11 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center border border-gray-200">
                ${placeholderSvg}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-600 mb-1">Ícono personalizado <span class="font-normal text-gray-400">(reemplaza el ícono del selector)</span></p>
                <div class="flex flex-wrap items-center gap-2">
                    <input type="file" accept="image/*" class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-medium file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 item-icon-file">
                    <button type="button" onclick="uploadItineraryIcon(${res.id}, this)"
                            class="px-2.5 py-1 rounded text-xs font-medium text-white bg-violet-600 hover:bg-violet-700">Subir</button>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-3 pt-2">
            <button type="button" onclick="saveItineraryItem(${res.id}, this)" class="text-xs px-3 py-1 bg-blue-600 text-white rounded">Guardar</button>
            <button type="button" onclick="deleteItineraryItem(${res.id}, this)" class="text-xs text-red-500">Eliminar</button>
        </div>
    </div>`;
    document.getElementById('itinerary-container').insertAdjacentHTML('beforeend', html);
}

async function uploadItineraryIcon(id, btn) {
    const row = btn.closest('[data-id]');
    const fileInput = row.querySelector('.item-icon-file');
    if (!fileInput.files.length) return;

    const formData = new FormData();
    formData.append('icon_file', fileInput.files[0]);

    btn.textContent = '...';
    btn.disabled = true;

    const res = await fetch(`/admin/itinerary/${id}/icon`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData,
    });
    const data = await res.json();

    btn.disabled = false;
    if (data.success) {
        const preview = row.querySelector('.item-icon-preview');
        preview.innerHTML = `<img src="${data.url}" class="w-full h-full object-contain p-1" alt="">`;
        fileInput.value = '';
        btn.textContent = '✓ Subido';
        setTimeout(() => { btn.textContent = 'Subir'; }, 2000);
        if (!row.querySelector('.item-icon-del-btn')) {
            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.className = 'text-xs text-red-400 hover:text-red-600 item-icon-del-btn';
            delBtn.textContent = 'Quitar';
            delBtn.onclick = () => deleteItineraryIcon(id, delBtn);
            btn.after(delBtn);
        }
    } else {
        btn.textContent = '✗ Error';
        setTimeout(() => { btn.textContent = 'Subir'; }, 2000);
    }
}

async function deleteItineraryIcon(id, btn) {
    const res = await fetch(`/admin/itinerary/${id}/icon`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken },
    });
    const data = await res.json();
    if (data.success) {
        const row = btn.closest('[data-id]');
        const placeholderSvg = `<svg class="w-5 h-5 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>`;
        row.querySelector('.item-icon-preview').innerHTML = placeholderSvg;
        btn.remove();
    }
}
</script>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
