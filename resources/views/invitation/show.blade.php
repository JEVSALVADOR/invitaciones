@php
    $c = (object)[
        'primary'   => $event->color_primary   ?: $theme->primary_color,
        'secondary' => $event->color_secondary  ?: $theme->secondary_color,
        'accent'    => $event->color_accent     ?: $theme->accent_color,
        'bg'        => $event->color_bg         ?: $theme->background_color,
        'text'      => $event->color_text       ?: $theme->text_color,
        'envelope'  => $event->color_envelope   ?: $theme->envelope_color,
        'seal'      => $event->color_seal       ?: $theme->seal_color,
    ];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="{{ $c->primary }}">
    <title>{{ $event->event_title }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&family=Pinyon+Script&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Alex+Brush&family=EB+Garamond:ital,wght@0,400;1,400&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/invitation.css">

    <!-- CSS Variables from theme (dynamic) -->
    <style>
        :root {
            --primary:    {{ $c->primary }};
            --secondary:  {{ $c->secondary }};
            --accent:     {{ $c->accent }};
            --bg:         {{ $c->bg }};
            --text:       {{ $c->text }};
            --envelope:   {{ $c->envelope }};
            --seal:       {{ $c->seal }};
            --font-script:  '{{ $theme->font_script }}', cursive;
            --font-display: '{{ $theme->font_display }}', serif;
            --font-body:    '{{ $theme->font_body }}', sans-serif;
        }
    </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════
     SECCIÓN 1: PORTADA (sobre cerrado)
     ═══════════════════════════════════════════════ -->
<section id="cover" class="invitation-cover">

    <div class="floral-top-left">
        @if($event->floralTopLeft)
            <img src="{{ Storage::url($event->floralTopLeft->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;">
        @else
            @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'top-left'])
        @endif
    </div>

    <div class="cover-text">
        <p class="invitation-label">
            @if($event->event_type === 'boda')
                ESTÁS CORDIALMENTE INVITADO <br>A NUESTRA BODA
            @elseif($event->event_type === 'quinceanera')
                ESTÁS CORDIALMENTE INVITADO <br>A LOS XV AÑOS DE
            @elseif($event->event_type === 'cumpleanos')
                ESTÁS CORDIALMENTE INVITADO <br>AL CUMPLEAÑOS DE
            @else
                ESTÁS CORDIALMENTE INVITADO <br>A CELEBRAR CON
            @endif
        </p>
    </div>

    <h1 class="couple-name" style="font-family: var(--font-script)">
        @if($event->event_type === 'boda' && $event->second_name)
            {{ $event->main_name }}<br><span class="ampersand-cover">&</span><br>{{ $event->second_name }}
        @else
            {{ $event->main_name }}
        @endif
    </h1>

    <div class="envelope-container" id="envelopeTrigger" role="button" tabindex="0" aria-label="Abrir invitación">
        <div class="envelope" id="envelope" style="background-color: {{ $c->envelope }}">
            <div class="envelope-flap" style="background-color: {{ $c->envelope }}; filter: brightness(0.82)"></div>
            {{-- envelope-body vacío: el sello se mueve fuera para quedar sobre el flap --}}
            <div class="envelope-body"></div>
        </div>

        {{-- Flores overlay (z-index 4) --}}
        <div class="envelope-flowers-overlay">
            @if($event->floralEnvelope)
                <img src="{{ Storage::url($event->floralEnvelope->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;">
            @else
                @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'envelope'])
            @endif
        </div>

        {{-- Sello fuera del envelope-body, z-index 5 → siempre delante del flap y de las flores --}}
        <div style="position:absolute;top:75%;left:50%;transform:translate(-50%,-50%);z-index:5;width:5.5rem;height:5.5rem;display:flex;align-items:center;justify-content:center;">

            {{-- Texto circular "CLICK AQUÍ" con SVG textPath --}}
            <svg viewBox="0 0 88 88" style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:visible;">
                <defs>
                    <path id="sealTopArc" d="M 5,44 A 39,39 0 0 1 83,44" fill="none"/>
                </defs>
                <text fill="white" font-size="9.5" letter-spacing="2.5" opacity="0.88" font-family="var(--font-body, sans-serif)" text-transform="uppercase">
                    <textPath href="#sealTopArc" startOffset="50%" text-anchor="middle">· CLICK AQUÍ ·</textPath>
                </text>
            </svg>

            {{-- Sello circular --}}
            @if($event->sealClosed)
            <div class="wax-seal" style="background:none;box-shadow:none;width:4rem;height:4rem;position:relative;flex-shrink:0;">
                <img src="{{ Storage::url($event->sealClosed->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;border-radius:50%;">
                @if($event->seal_initials)
                <span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:white;font-family:var(--font-script);font-size:1.15rem;text-shadow:0 1px 4px rgba(0,0,0,0.55);pointer-events:none;z-index:2;white-space:nowrap;">{{ $event->seal_initials }}</span>
                @endif
            </div>
            @else
            <div class="wax-seal" style="background:radial-gradient(circle at 40% 35%, {{ $c->seal }}, #8B6914);width:4rem;height:4rem;flex-shrink:0;">
                @if($event->seal_initials)
                <span style="color:white;font-family:var(--font-script);font-size:1.15rem;text-shadow:0 1px 4px rgba(0,0,0,0.4);">{{ $event->seal_initials }}</span>
                @else
                <div class="seal-inner">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 21.7C6.1 18.4 2 13.8 2 9.5C2 6.4 4.7 4 8 4C9.8 4 11.4 4.8 12 5.6C12.6 4.8 14.2 4 16 4C19.3 4 22 6.4 22 9.5C22 13.8 17.9 18.4 12 21.7Z" fill="white" opacity="0.6"/>
                    </svg>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>

    {{-- Mensaje invitación general (solo cuando no hay invitado personalizado) --}}
    @if(!$guestName && $event->general_invite_message)
    <div class="guest-info" style="margin-top:2.5rem;">
        <p style="font-size:1rem;letter-spacing:0.16em;text-transform:uppercase;color:var(--primary);opacity:0.75;font-family:var(--font-body);">
            {{ $event->general_invite_message }}
        </p>
    </div>
    @endif

    @if($guestName)
    <div class="guest-info">
        <p class="guest-name-label">PARA</p>
        <p class="guest-name-display" style="font-family: var(--font-script)">{{ $guestName }}</p>
        @if($guest && $guest->seats_reserved > 0)
        <p class="seats-reserved-text">
            Hemos reservado <strong>{{ $guest->seats_reserved }}</strong>
            {{ $guest->seats_reserved === 1 ? 'lugar' : 'lugares' }} en tu honor
        </p>
        @endif
    </div>
    @endif

    <div class="floral-bottom-right">
        @if($event->floralBottomRight)
            <img src="{{ Storage::url($event->floralBottomRight->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;">
        @else
            @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'bottom-right'])
        @endif
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     CONTENIDO PRINCIPAL (oculto hasta abrir sobre)
     ═══════════════════════════════════════════════ -->
<div id="invitation-content" class="hidden-initially">

<!-- ═══════════════════════════════════════════════
     SECCIÓN 2: SOBRE ABIERTO + FOTO POLAROID
     ═══════════════════════════════════════════════ -->
<section class="open-envelope-section scroll-reveal">

    {{-- ── Sobre abierto ────────────────────────────────────────────── --}}
    <div class="opened-envelope">
        <div class="opened-env-body" style="background-color: {{ $c->envelope }}">
            {{-- Overlay oscuro interior del sobre (sin afectar hijos con filter) --}}
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.22);z-index:0;border-radius:0 0 8px 8px;pointer-events:none;"></div>

            {{-- Solapa abierta: triángulo con punta arriba, posicionado
                 encima del cuerpo con rotación 3D (translateY -100%) --}}
            <div class="opened-flap"
                 style="background-color: {{ $c->envelope }}; filter: brightness(0.92)"></div>

            {{-- Sombras diagonales interiores del sobre --}}
            <div class="inner-corner-l"></div>
            <div class="inner-corner-r"></div>

            {{-- Foto que emerge del sobre hacia arriba --}}
            <div class="photo-in-env">
                @if($event->mainPhoto)
                <div class="polaroid-photo">
                    <img src="{{ Storage::url($event->mainPhoto->file_path) }}" alt="{{ $event->main_name }}">
                    <div class="polaroid-caption" style="font-family: var(--font-script); color: var(--primary)">
                        {{ $event->main_name }}
                    </div>
                </div>
                @else
                <div class="polaroid-photo polaroid-placeholder">
                    <div class="photo-placeholder-inner" style="background: rgba(255,255,255,0.15)">
                        <span style="font-size: 3rem">📷</span>
                    </div>
                    <div class="polaroid-caption" style="font-family: var(--font-script); color: var(--primary)">
                        {{ $event->main_name }}
                    </div>
                </div>
                @endif
            </div>

            {{-- Cara frontal del sobre: cubre la parte inferior de la foto
                 y forma la V-notch (polígono) que da efecto de sobre real --}}
            <div class="front-flaps"></div>

            {{-- Flores decorativas del sobre abierto: misma imagen/SVG
                 que se usa en el overlay del sobre cerrado --}}
            <div class="open-env-flowers">
                @if($event->floralEnvelope)
                    <img src="{{ Storage::url($event->floralEnvelope->file_path) }}"
                         alt="" style="width:100%;height:auto;object-fit:contain;">
                @else
                    @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'envelope'])
                @endif
            </div>

        </div>
    </div>
    {{-- ────────────────────────────────────────────────────────────── --}}

    <!-- Tarjeta oval -->
    <div class="oval-card">
        {{-- Sello posicionado en el borde superior del oval-card:
             mitad encima (en el opened-env-body), mitad adentro --}}
        @if($event->sealOpen)
        <div class="oval-seal-decoration" style="position:absolute;top:-2rem;left:50%;transform:translateX(-50%);background:none;box-shadow:none;width:4rem;height:4rem;z-index:5;">
            <img src="{{ Storage::url($event->sealOpen->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;border-radius:50%;">
            @if($event->seal_initials)
            <span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:white;font-family:var(--font-script);font-size:1rem;text-shadow:0 1px 4px rgba(0,0,0,0.55);pointer-events:none;z-index:2;white-space:nowrap;">{{ $event->seal_initials }}</span>
            @endif
        </div>
        @else
        <div class="oval-seal-decoration" style="position:absolute;top:-2rem;left:50%;transform:translateX(-50%);background:radial-gradient(circle at 40% 35%, {{ $c->seal }}, #8B6914);width:4rem;height:4rem;z-index:5;">
            @if($event->seal_initials)
            <span style="color:white;font-family:var(--font-script);font-size:1rem;text-shadow:0 1px 4px rgba(0,0,0,0.4);">{{ $event->seal_initials }}</span>
            @else
            <div class="oval-seal-inner">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M12 21.7C6.1 18.4 2 13.8 2 9.5C2 6.4 4.7 4 8 4C9.8 4 11.4 4.8 12 5.6C12.6 4.8 14.2 4 16 4C19.3 4 22 6.4 22 9.5C22 13.8 17.9 18.4 12 21.7Z" fill="white" opacity="0.7"/>
                </svg>
            </div>
            @endif
        </div>
        @endif

        <p class="honor-text">TENEMOS EL HONOR DE INVITARTE A</p>

        <p class="honor-type">
            @if($event->event_type === 'boda') NUESTRA BODA
            @elseif($event->event_type === 'quinceanera') LA FIESTA DE XV AÑOS
            @elseif($event->event_type === 'cumpleanos') NUESTRO CUMPLEAÑOS
            @else NUESTRA CELEBRACIÓN
            @endif
        </p>

        <h2 class="name-script" style="font-family: var(--font-script); color: {{ $c->accent }}">
            {{ $event->main_name }}
        </h2>

        @if($event->event_type === 'boda' && $event->second_name)
        <span class="ampersand" style="color: var(--text)">&</span>
        <h2 class="name-script" style="font-family: var(--font-script); color: {{ $c->accent }}">
            {{ $event->second_name }}
        </h2>
        @endif

        @if($event->bible_verse)
        <blockquote class="bible-verse">
            "{{ $event->bible_verse }}"
            @if($event->bible_reference)
            <cite>— {{ $event->bible_reference }}</cite>
            @endif
        </blockquote>
        @endif
    </div>

    <div class="section-floral-divider">
        @if($event->floralDivider)
            <img src="{{ Storage::url($event->floralDivider->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;">
        @else
            @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'divider'])
        @endif
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     SECCIÓN 3: REPRODUCTOR DE MÚSICA
     ═══════════════════════════════════════════════ -->
@if($event->show_music_player)
<section class="music-section scroll-reveal">
    <p class="music-label">♪ PRESIONA PLAY PARA ESCUCHAR NUESTRA CANCIÓN ♪</p>

    <div class="music-player" id="customPlayer">
        @if($event->song_file_path)
        <audio id="audioPlayer" src="{{ Storage::url($event->song_file_path) }}" loop preload="none"></audio>
        @else
        <audio id="audioPlayer" preload="none"></audio>
        @endif

        <div class="player-controls">
            <button class="ctrl-btn active" id="repeatBtn" onclick="toggleRepeat()" title="Repetir">↺</button>
            <button class="ctrl-btn disabled-btn" title="Anterior">⏮</button>
            <button class="play-btn" id="playBtn" onclick="togglePlay()" style="border-color: var(--primary); color: var(--primary)">
                <span class="play-icon" id="playIcon">▶</span>
            </button>
            <button class="ctrl-btn disabled-btn" title="Siguiente">⏭</button>
            <button class="ctrl-btn" id="shuffleBtn" onclick="void(0)" style="opacity: 0.3" title="Aleatorio">⇄</button>
        </div>

        @if($event->song_title)
        <p class="song-info">
            <span class="song-title-text">{{ $event->song_title }}</span>
            @if($event->song_artist)
            <span class="song-separator"> — </span>
            <span class="song-artist-text">{{ $event->song_artist }}</span>
            @endif
        </p>
        @endif
    </div>

    @if($event->love_message)
    <div class="love-message-container">
        <p class="love-message">{{ $event->love_message }}</p>
    </div>
    @endif
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 4: SEGUNDA FOTO
     ═══════════════════════════════════════════════ -->
@if($event->secondPhoto)
<section class="photo-section scroll-reveal">
    <div class="photo-frame gold-border" style="border-color: {{ $c->accent }}">
        <img src="{{ Storage::url($event->secondPhoto->file_path) }}" alt="{{ $event->main_name }}">
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 5: CALENDARIO "RESERVA LA FECHA"
     ═══════════════════════════════════════════════ -->
<section class="calendar-section scroll-reveal">
    <div class="floral-cal-tl">
        @if($event->floralCalTl)
            <img src="{{ Storage::url($event->floralCalTl->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;">
        @else
            @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'cal-corner'])
        @endif
    </div>

    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">
        Reserva la fecha
    </h2>

    <p class="event-date-display" style="color: var(--primary)">
        {{ \Carbon\Carbon::parse($event->event_date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
    </p>

    <div class="calendar-widget"
         id="eventCalendar"
         data-event-date="{{ $event->event_date->format('Y-m-d') }}">
        <!-- Rendered by JS -->
    </div>

    <div class="floral-cal-br">
        @if($event->floralCalBr)
            <img src="{{ Storage::url($event->floralCalBr->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;">
        @else
            @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'cal-corner-br'])
        @endif
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     SECCIÓN 6: CUENTA REGRESIVA
     ═══════════════════════════════════════════════ -->
@if($event->show_countdown)
<section class="countdown-section scroll-reveal" style="background-color: {{ $c->primary }}">
    <h2 class="countdown-title" style="font-family: var(--font-script)">Faltan</h2>
    <div class="countdown-display"
         id="countdownTimer"
         data-target="{{ $event->event_date->format('Y-m-d') }}T{{ $event->ceremony_time ?? '00:00:00' }}">
        <div class="time-unit">
            <span class="time-number" id="days">00</span>
            <span class="time-label">DÍAS</span>
        </div>
        <span class="time-separator">:</span>
        <div class="time-unit">
            <span class="time-number" id="hours">00</span>
            <span class="time-label">HORAS</span>
        </div>
        <span class="time-separator">:</span>
        <div class="time-unit">
            <span class="time-number" id="minutes">00</span>
            <span class="time-label">MIN</span>
        </div>
        <span class="time-separator">:</span>
        <div class="time-unit">
            <span class="time-number" id="seconds">00</span>
            <span class="time-label">SEG</span>
        </div>
    </div>
    <p class="countdown-for">Para el gran día</p>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 6B: ITINERARIO
     ═══════════════════════════════════════════════ -->
@if($event->show_itinerary && $event->itinerary->count())
<section class="itinerary-section scroll-reveal">
    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">
        Itinerario
    </h2>

    <div class="timeline">
        <div class="timeline-line" style="background: linear-gradient(to bottom, {{ $c->primary }}, {{ $c->accent }})"></div>

        @foreach($event->itinerary as $item)
        <div class="timeline-item {{ $item->position }}-side">
            <div class="timeline-content">
                <div class="timeline-icon" style="color: {{ $c->accent }}">
                    @include('invitation.partials.timeline-icon', ['type' => $item->icon_type, 'icon_image' => $item->icon_image, 'theme' => $theme])
                </div>
                <span class="timeline-time" style="color: {{ $c->primary }}">{{ $item->time_label }}</span>
                <span class="timeline-activity">{{ $item->activity_name }}</span>
            </div>
            <div class="timeline-dot" style="background: {{ $c->primary }}; border-color: {{ $c->accent }}"></div>
        </div>
        @endforeach
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 7: UBICACIÓN
     ═══════════════════════════════════════════════ -->
@if($event->locations->count())
<section class="location-section scroll-reveal">
    <div class="location-pin-icon" style="color: {{ $c->accent }}">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
    </div>
    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">
        Ubicación
    </h2>

    @foreach($event->locations as $location)
    <div class="location-card" style="border-left-color: {{ $c->primary }}">
        <div class="location-type" style="color: {{ $c->primary }}">{{ strtoupper($location->location_type) }}</div>
        <div class="location-details">
            @if($location->venue_name)
            <strong class="venue-name">{{ $location->venue_name }}</strong><br>
            @endif
            <span class="address-text">{{ $location->address }}</span>
            @if($location->city)
            <span>, {{ $location->city }}</span>
            @endif
        </div>
        @if($location->event_time)
        <div class="location-time" style="color: {{ $c->primary }}">
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $location->event_time)->format('g:i A') }}
        </div>
        @endif
    </div>
    @endforeach

    @if($event->locations->first()?->google_maps_url)
    <a href="{{ $event->locations->first()->google_maps_url }}" target="_blank" rel="noopener"
       class="btn-primary" style="background-color: {{ $c->primary }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="white" style="display:inline-block;vertical-align:middle;margin-right:6px;flex-shrink:0">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
        VER MAPA
    </a>
    @endif
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 8A: DRESS CODE
     ═══════════════════════════════════════════════ -->
@if($event->show_dress_code && ($event->dress_code_general || $event->dress_code_women || $event->dress_code_men))
<section class="dresscode-section scroll-reveal">
    <div class="dresscode-icon" style="color: {{ $c->accent }}; display:flex; align-items:flex-end; justify-content:center; gap:24px">

        {{-- VESTIDO --}}
        <svg viewBox="0 0 56 90" width="52" height="78" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            {{-- Tirante izquierdo --}}
            <rect x="17" y="2" width="8" height="17" rx="4"/>
            {{-- Tirante derecho --}}
            <rect x="31" y="2" width="8" height="17" rx="4"/>
            {{-- Cuerpo: bust → talle (reloj de arena) → falda acampanada --}}
            <path d="M16 17 Q13 27 18 38 L6 86 L50 86 L38 38 Q43 27 40 17 Q34 13 28 13 Q22 13 16 17 Z"/>
        </svg>

        {{-- TERNO --}}
        <svg viewBox="0 0 56 90" width="52" height="78" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            {{-- Panel izquierdo de la chaqueta (con solapa) --}}
            <path d="M3 4 L3 86 L24 86 L24 30 L18 14 L11 4 Z"/>
            {{-- Panel derecho de la chaqueta (con solapa) --}}
            <path d="M53 4 L53 86 L32 86 L32 30 L38 14 L45 4 Z"/>
            {{-- Corbata (visible en la abertura de la V) --}}
            <path d="M25 28 L24 60 L28 68 L32 60 L31 28 Q28 33 25 28 Z"/>
            {{-- Puntas del cuello de la camisa (arriba de la V) --}}
            <path d="M18 14 L22 20 L28 14 L34 20 L38 14 Q33 10 28 10 Q23 10 18 14 Z"/>
        </svg>

    </div>

    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">Dress Code</h2>

    @if($event->dress_code_general)
    <p class="dress-badge" style="background: {{ $c->primary }}; color: white">{{ $event->dress_code_general }}</p>
    @endif

    <div class="dress-details">
        @if($event->dress_code_women)
        <div class="dress-item">
            <span class="dress-gender" style="color: {{ $c->accent }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor" style="display:inline-block;vertical-align:middle;margin-right:5px;margin-bottom:3px">
                    <path d="M12 2C9.24 2 7 4.24 7 7s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm-1 2h2v2h2v2h-2v2h-2v-2H9v-2h2v-2z"/>
                </svg>
                Mujeres
            </span>
            <p>{{ $event->dress_code_women }}</p>
        </div>
        @endif
        @if($event->dress_code_men)
        <div class="dress-item">
            <span class="dress-gender" style="color: {{ $c->primary }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor" style="display:inline-block;vertical-align:middle;margin-right:5px;margin-bottom:3px">
                    <path d="M9 9c1.29 0 2.49.42 3.47 1.12L17.59 5H14V3h7v7h-2V6.41l-5.12 5.12C14.58 12.51 15 13.7 15 15c0 3.31-2.69 6-6 6s-6-2.69-6-6 2.69-6 6-6zm0 2c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                </svg>
                Hombres
            </span>
            <p>{{ $event->dress_code_men }}</p>
        </div>
        @endif
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 8B: SUGERENCIA DE REGALOS
     ═══════════════════════════════════════════════ -->
@if($event->show_gift_suggestion && $event->gift_suggestion_text)
<section class="gift-section scroll-reveal" style="background-color: {{ $c->primary }}">
    <div class="gift-icon">
        <svg viewBox="0 0 64 82" width="56" height="71" xmlns="http://www.w3.org/2000/svg">
            {{-- Cuerpo de la caja (blanco) --}}
            <rect x="6" y="36" width="52" height="42" rx="3" fill="white"/>
            {{-- Tapa de la caja (blanca, ligeramente más ancha) --}}
            <rect x="3" y="26" width="58" height="12" rx="3" fill="white"/>
            {{-- Cinta vertical (color primario, cruza tapa y cuerpo) --}}
            <rect x="27" y="26" width="10" height="52" fill="{{ $c->primary }}"/>
            {{-- Lazada izquierda del moño --}}
            <path d="M30 26 C26 2 0 4 6 20 C8 26 20 28 30 26 Z" fill="{{ $c->primary }}"/>
            {{-- Lazada derecha del moño --}}
            <path d="M34 26 C38 2 64 4 58 20 C56 26 44 28 34 26 Z" fill="{{ $c->primary }}"/>
            {{-- Nudo central del moño --}}
            <ellipse cx="32" cy="24" rx="6" ry="5" fill="{{ $c->primary }}"/>
        </svg>
    </div>
    <h2 class="section-title-script" style="font-family: var(--font-script); color: white">
        Sugerencia de regalos
    </h2>
    <p class="gift-text">{{ $event->gift_suggestion_text }}</p>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 9: RECOMENDACIONES
     ═══════════════════════════════════════════════ -->
@if($event->show_recommendations && $event->recommendations)
<section class="recommendations-section scroll-reveal">
    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">
        Recomendaciones
    </h2>

    <div class="recommendations-grid">
        @foreach($event->recommendations as $rec)
        <div class="recommendation-item">
            <div class="rec-icon" style="color: {{ $c->accent }}">
                @include('invitation.partials.rec-icon', ['icon' => $rec['icon'] ?? 'clock'])
            </div>
            <p class="rec-text">{{ $rec['text'] }}</p>
        </div>
        @endforeach
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 10: TERCERA FOTO (papel rasgado)
     ═══════════════════════════════════════════════ -->
@php
    $tornPhotos = collect([$event->thirdPhoto, $event->thirdPhoto2, $event->thirdPhoto3, $event->thirdPhoto4])->filter()->values();
@endphp
@if($tornPhotos->isNotEmpty())
<section class="torn-photo-section scroll-reveal">
    <div class="torn-top">
        @if($event->tornTop)
            <img src="{{ Storage::url($event->tornTop->file_path) }}"
                 alt="" style="width:100%;height:100%;object-fit:fill;display:block;">
        @else
            <svg viewBox="0 0 500 35" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,35 L0,18 Q20,5 45,20 Q70,35 100,14 Q125,0 155,22 Q180,38 210,12 Q235,0 265,24 Q290,40 320,16 Q345,5 375,26 Q400,42 430,14 Q455,2 480,22 Q495,32 500,18 L500,35 Z" fill="{{ $c->bg }}"/>
            </svg>
        @endif
    </div>
    <div class="torn-photo-frame">
        @if($tornPhotos->count() === 1)
            <img src="{{ Storage::url($tornPhotos->first()->file_path) }}"
                 alt="{{ $event->main_name }}" class="torn-photo">
        @else
            <div class="torn-slideshow">
                @foreach($tornPhotos as $i => $photo)
                <img src="{{ Storage::url($photo->file_path) }}"
                     alt="{{ $event->main_name }}"
                     class="torn-photo-slide{{ $i === 0 ? ' active' : '' }}">
                @endforeach
            </div>
        @endif
    </div>
    <div class="torn-bottom">
        @if($event->tornBottom)
            <img src="{{ Storage::url($event->tornBottom->file_path) }}"
                 alt="" style="width:100%;height:100%;object-fit:fill;display:block;">
        @else
            <svg viewBox="0 0 500 35" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,0 L0,16 Q20,28 48,12 Q72,0 100,20 Q126,35 155,12 Q178,0 210,22 Q235,38 265,10 Q290,0 318,18 Q345,32 375,8 Q398,0 428,20 Q454,35 482,12 L500,16 L500,0 Z" fill="{{ $c->bg }}"/>
            </svg>
        @endif
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 11: CONFIRMACIÓN DE ASISTENCIA (RSVP)
     ═══════════════════════════════════════════════ -->
@if($event->show_rsvp)
<section class="rsvp-section scroll-reveal">
    <div class="rsvp-envelope-deco" style="background-color: {{ $c->envelope }}"></div>

    <div class="rsvp-card">
        @if($event->sealOpen)
        <div class="rsvp-seal" style="background:none;box-shadow:none;width:4rem;height:4rem;position:relative;">
            <img src="{{ Storage::url($event->sealOpen->file_path) }}" alt="" style="width:100%;height:100%;object-fit:contain;border-radius:50%;">
            @if($event->seal_initials)
            <span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:white;font-family:var(--font-script);font-size:1rem;text-shadow:0 1px 4px rgba(0,0,0,0.55);pointer-events:none;z-index:2;white-space:nowrap;">{{ $event->seal_initials }}</span>
            @endif
        </div>
        @else
        <div class="rsvp-seal" style="background:radial-gradient(circle at 40% 35%, {{ $c->seal }}, #8B6914);width:4rem;height:4rem;">
            @if($event->seal_initials)
            <span style="color:white;font-family:var(--font-script);font-size:1rem;text-shadow:0 1px 4px rgba(0,0,0,0.4);">{{ $event->seal_initials }}</span>
            @else
            <div class="rsvp-seal-inner">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path d="M12 21.7C6.1 18.4 2 13.8 2 9.5C2 6.4 4.7 4 8 4C9.8 4 11.4 4.8 12 5.6C12.6 4.8 14.2 4 16 4C19.3 4 22 6.4 22 9.5C22 13.8 17.9 18.4 12 21.7Z" fill="white" opacity="0.7"/>
                </svg>
            </div>
            @endif
        </div>
        @endif

        <h2 class="section-title-script rsvp-title" style="font-family: var(--font-script); color: var(--primary)">
            Confirma<br>tu asistencia
        </h2>
        <p class="rsvp-description">Es muy importante que confirmes si podrás acompañarnos en este momento tan especial.</p>

        <form id="rsvpForm" action="{{ route('invitation.rsvp', $event->uuid) }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="guest_id" value="{{ $guest?->id }}">

            <div class="form-group">
                <input type="text" name="respondent_name"
                       placeholder="Tu nombre completo" required
                       class="rsvp-input"
                       value="{{ $guestName ?? '' }}"
                       style="border-color: #ddd; outline-color: {{ $c->primary }}">
            </div>

            <div class="form-group attendance-options">
                <label class="attendance-option">
                    <input type="radio" name="attendance_option" value="solo_yo" style="accent-color: {{ $c->primary }}">
                    <span class="option-text">Solo Yo</span>
                </label>
                <label class="attendance-option">
                    <input type="radio" name="attendance_option" value="yo_y_pareja" style="accent-color: {{ $c->primary }}">
                    <span class="option-text">Yo y mi pareja</span>
                </label>
                <label class="attendance-option">
                    <input type="radio" name="attendance_option" value="no_asistire" style="accent-color: {{ $c->primary }}">
                    <span class="option-text">No podré asistir</span>
                </label>
            </div>

            <div class="form-group">
                <textarea name="message" placeholder="Mensaje opcional..." rows="3" class="rsvp-input rsvp-textarea"
                          style="outline-color: {{ $c->primary }}"></textarea>
            </div>

            <button type="submit" class="btn-primary rsvp-submit" style="background-color: {{ $c->primary }}">
                CONFIRMAR ASISTENCIA
            </button>
        </form>
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 12: CONTACTO
     ═══════════════════════════════════════════════ -->
@if($event->contact_whatsapp)
<section class="contact-section scroll-reveal">
    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">
        ¿Necesitas ayuda?
    </h2>
    <p class="contact-desc">Si tienes alguna duda, escríbenos con gusto te ayudamos.</p>

    @php
        $waNumber = preg_replace('/[^0-9]/', '', $event->contact_whatsapp);
        $waMessage = urlencode('Hola! Tengo una pregunta sobre la invitación de ' . $event->main_name);
    @endphp
    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}"
       target="_blank" rel="noopener"
       class="btn-primary whatsapp-btn" style="background-color: var(--primary)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="white" style="display:inline-block;vertical-align:middle;margin-right:7px;flex-shrink:0">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        ENVIAR MENSAJE
    </a>

    @if($event->contact_name)
    <p class="contact-name" style="color: var(--text); opacity: 0.7; margin-top: 10px; font-size: 0.85rem">
        {{ $event->contact_name }}
    </p>
    @endif
</section>
@endif


<!-- ═══════════════════════════════════════════════
     FOOTER
     ═══════════════════════════════════════════════ -->
<footer class="invitation-footer" style="background-color: {{ $c->primary }}">
    <p class="footer-floral" style="opacity: 0.4">✿ ✿ ✿</p>
    <p class="footer-name" style="font-family: var(--font-script); color: white">
        @if($event->event_type === 'boda' && $event->second_name)
            {{ $event->main_name }} & {{ $event->second_name }}
        @else
            {{ $event->main_name }}
        @endif
    </p>
    <p class="footer-date" style="color: rgba(255,255,255,0.7)">
        {{ \Carbon\Carbon::parse($event->event_date)->locale('es')->isoFormat('D [de] MMMM, YYYY') }}
    </p>
</footer>

</div><!-- /invitation-content -->

<script src="/js/invitation.js"></script>
</body>
</html>
