<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="{{ $theme->primary_color }}">
    <title>{{ $event->event_title }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&family=Pinyon+Script&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Alex+Brush&family=EB+Garamond:ital,wght@0,400;1,400&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/invitation.css">

    <!-- CSS Variables from theme (dynamic) -->
    <style>
        :root {
            --primary:    {{ $theme->primary_color }};
            --secondary:  {{ $theme->secondary_color }};
            --accent:     {{ $theme->accent_color }};
            --bg:         {{ $theme->background_color }};
            --text:       {{ $theme->text_color }};
            --envelope:   {{ $theme->envelope_color }};
            --seal:       {{ $theme->seal_color }};
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
        @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'top-left'])
    </div>

    <div class="cover-text">
        <p class="invitation-label">
            @if($event->event_type === 'boda')
                ESTÁS CORDIALMENTE INVITADO A LA BODA DE
            @elseif($event->event_type === 'quinceanera')
                ESTÁS CORDIALMENTE INVITADO A LOS XV AÑOS DE
            @elseif($event->event_type === 'cumpleanos')
                ESTÁS CORDIALMENTE INVITADO AL CUMPLEAÑOS DE
            @else
                ESTÁS CORDIALMENTE INVITADO A CELEBRAR CON
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
        <div class="envelope" id="envelope" style="background-color: {{ $theme->envelope_color }}">
            <div class="envelope-flap" style="background-color: {{ $theme->envelope_color }}; filter: brightness(0.82)"></div>
            <div class="envelope-body">
                <span class="click-label">TOCA PARA ABRIR</span>
                <div class="wax-seal" style="background: radial-gradient(circle at 40% 35%, {{ $theme->accent_color }}, #8B6914)">
                    <div class="seal-inner">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21.7C6.1 18.4 2 13.8 2 9.5C2 6.4 4.7 4 8 4C9.8 4 11.4 4.8 12 5.6C12.6 4.8 14.2 4 16 4C19.3 4 22 6.4 22 9.5C22 13.8 17.9 18.4 12 21.7Z" fill="white" opacity="0.6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="envelope-flowers-overlay">
            @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'envelope'])
        </div>
    </div>

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
        @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'bottom-right'])
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
    <div class="open-envelope-bg" style="background-color: {{ $theme->envelope_color }}">
        <div class="open-env-flap" style="border-bottom-color: {{ $theme->envelope_color }}; filter: brightness(0.82)"></div>

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

    <!-- Tarjeta oval -->
    <div class="oval-card">
        <div class="oval-seal-decoration" style="background: radial-gradient(circle at 40% 35%, {{ $theme->accent_color }}, #8B6914)">
            <div class="oval-seal-inner">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M12 21.7C6.1 18.4 2 13.8 2 9.5C2 6.4 4.7 4 8 4C9.8 4 11.4 4.8 12 5.6C12.6 4.8 14.2 4 16 4C19.3 4 22 6.4 22 9.5C22 13.8 17.9 18.4 12 21.7Z" fill="white" opacity="0.7"/>
                </svg>
            </div>
        </div>

        <p class="honor-text">TENEMOS EL HONOR DE INVITARTE A</p>

        <p class="honor-type">
            @if($event->event_type === 'boda') NUESTRA BODA
            @elseif($event->event_type === 'quinceanera') LA FIESTA DE XV AÑOS
            @elseif($event->event_type === 'cumpleanos') NUESTRO CUMPLEAÑOS
            @else NUESTRA CELEBRACIÓN
            @endif
        </p>

        <h2 class="name-script" style="font-family: var(--font-script); color: {{ $theme->accent_color }}">
            {{ $event->main_name }}
        </h2>

        @if($event->event_type === 'boda' && $event->second_name)
        <span class="ampersand" style="color: var(--text)">&</span>
        <h2 class="name-script" style="font-family: var(--font-script); color: {{ $theme->accent_color }}">
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
        @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'divider'])
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
    <div class="photo-frame gold-border" style="border-color: {{ $theme->accent_color }}">
        <img src="{{ Storage::url($event->secondPhoto->file_path) }}" alt="{{ $event->main_name }}">
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 5: CALENDARIO "RESERVA LA FECHA"
     ═══════════════════════════════════════════════ -->
<section class="calendar-section scroll-reveal">
    <div class="floral-cal-tl">
        @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'cal-corner'])
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
        @include('invitation.partials.floral-svg', ['style' => $theme->floral_style, 'position' => 'cal-corner-br'])
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     SECCIÓN 6: CUENTA REGRESIVA
     ═══════════════════════════════════════════════ -->
@if($event->show_countdown)
<section class="countdown-section scroll-reveal" style="background-color: {{ $theme->primary_color }}">
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
        <div class="timeline-line" style="background: linear-gradient(to bottom, {{ $theme->primary_color }}, {{ $theme->accent_color }})"></div>

        @foreach($event->itinerary as $item)
        <div class="timeline-item {{ $item->position }}-side">
            <div class="timeline-content">
                <div class="timeline-icon" style="color: {{ $theme->accent_color }}">
                    @include('invitation.partials.timeline-icon', ['type' => $item->icon_type, 'theme' => $theme])
                </div>
                <span class="timeline-time" style="color: {{ $theme->primary_color }}">{{ $item->time_label }}</span>
                <span class="timeline-activity">{{ $item->activity_name }}</span>
            </div>
            <div class="timeline-dot" style="background: {{ $theme->primary_color }}; border-color: {{ $theme->accent_color }}"></div>
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
    <div class="location-pin-icon" style="color: {{ $theme->accent_color }}">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
    </div>
    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">
        Ubicación
    </h2>

    @foreach($event->locations as $location)
    <div class="location-card" style="border-left-color: {{ $theme->primary_color }}">
        <div class="location-type" style="color: {{ $theme->primary_color }}">{{ strtoupper($location->location_type) }}</div>
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
        <div class="location-time" style="color: {{ $theme->primary_color }}">
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $location->event_time)->format('g:i A') }}
        </div>
        @endif
    </div>
    @endforeach

    @if($event->locations->first()?->google_maps_url)
    <a href="{{ $event->locations->first()->google_maps_url }}" target="_blank" rel="noopener"
       class="btn-primary" style="background-color: {{ $theme->primary_color }}">
        📍 VER MAPA
    </a>
    @endif
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 8A: DRESS CODE
     ═══════════════════════════════════════════════ -->
@if($event->show_dress_code && ($event->dress_code_general || $event->dress_code_women || $event->dress_code_men))
<section class="dresscode-section scroll-reveal">
    <div class="dresscode-icon" style="color: {{ $theme->accent_color }}">
        <svg width="60" height="60" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Silueta vestido (mujer) -->
            <path d="M30 10 Q25 20 20 35 Q15 50 18 70 Q22 80 30 82 L38 82 Q35 70 35 55 Q35 45 30 38Z" fill="currentColor" opacity="0.6"/>
            <ellipse cx="30" cy="10" rx="6" ry="6" fill="currentColor" opacity="0.6"/>
            <!-- Silueta traje (hombre) -->
            <path d="M70 10 Q75 20 80 35 Q85 50 82 70 Q78 80 70 82 L62 82 Q65 70 65 55 Q65 45 70 38Z" fill="currentColor" opacity="0.9"/>
            <ellipse cx="70" cy="10" rx="6" ry="6" fill="currentColor" opacity="0.9"/>
            <path d="M68 20 L70 30 L72 20" stroke="white" stroke-width="1.5" fill="none"/>
        </svg>
    </div>

    <h2 class="section-title-script" style="font-family: var(--font-script); color: var(--primary)">Dress Code</h2>

    @if($event->dress_code_general)
    <p class="dress-badge" style="background: {{ $theme->primary_color }}; color: white">{{ $event->dress_code_general }}</p>
    @endif

    <div class="dress-details">
        @if($event->dress_code_women)
        <div class="dress-item">
            <span class="dress-gender" style="color: {{ $theme->accent_color }}">♀ Mujeres</span>
            <p>{{ $event->dress_code_women }}</p>
        </div>
        @endif
        @if($event->dress_code_men)
        <div class="dress-item">
            <span class="dress-gender" style="color: {{ $theme->primary_color }}">♂ Hombres</span>
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
<section class="gift-section scroll-reveal" style="background-color: {{ $theme->primary_color }}">
    <div class="gift-icon">
        <svg width="50" height="50" viewBox="0 0 24 24" fill="white" opacity="0.9">
            <path d="M20 6h-2.18c.07-.34.18-.68.18-1 0-2.21-1.79-4-4-4S10 2.79 10 5c0 .32.11.66.18 1H8c-1.1 0-2 .9-2 2v1c0 .55.45 1 1 1h14c.55 0 1-.45 1-1V8c0-1.1-.9-2-2-2zm-8-1c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zM5 20c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V10H5v10zm2-8h10v8H7v-8z"/>
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
            <div class="rec-icon" style="color: {{ $theme->accent_color }}">
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
@if($event->thirdPhoto)
<section class="torn-photo-section scroll-reveal">
    <div class="torn-top">
        <svg viewBox="0 0 500 35" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,35 L0,18 Q20,5 45,20 Q70,35 100,14 Q125,0 155,22 Q180,38 210,12 Q235,0 265,24 Q290,40 320,16 Q345,5 375,26 Q400,42 430,14 Q455,2 480,22 Q495,32 500,18 L500,35 Z" fill="{{ $theme->background_color }}"/>
        </svg>
    </div>
    <img src="{{ Storage::url($event->thirdPhoto->file_path) }}"
         alt="{{ $event->main_name }}" class="torn-photo">
    <div class="torn-bottom">
        <svg viewBox="0 0 500 35" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,0 L0,16 Q20,28 48,12 Q72,0 100,20 Q126,35 155,12 Q178,0 210,22 Q235,38 265,10 Q290,0 318,18 Q345,32 375,8 Q398,0 428,20 Q454,35 482,12 L500,16 L500,0 Z" fill="{{ $theme->background_color }}"/>
        </svg>
    </div>
</section>
@endif


<!-- ═══════════════════════════════════════════════
     SECCIÓN 11: CONFIRMACIÓN DE ASISTENCIA (RSVP)
     ═══════════════════════════════════════════════ -->
@if($event->show_rsvp)
<section class="rsvp-section scroll-reveal">
    <div class="rsvp-envelope-deco" style="background-color: {{ $theme->envelope_color }}"></div>

    <div class="rsvp-card">
        <div class="rsvp-seal" style="background: radial-gradient(circle at 40% 35%, {{ $theme->accent_color }}, #8B6914)">
            <div class="rsvp-seal-inner">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path d="M12 21.7C6.1 18.4 2 13.8 2 9.5C2 6.4 4.7 4 8 4C9.8 4 11.4 4.8 12 5.6C12.6 4.8 14.2 4 16 4C19.3 4 22 6.4 22 9.5C22 13.8 17.9 18.4 12 21.7Z" fill="white" opacity="0.7"/>
                </svg>
            </div>
        </div>

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
                       style="border-color: #ddd; outline-color: {{ $theme->primary_color }}">
            </div>

            <div class="form-group attendance-options">
                <label class="attendance-option">
                    <input type="radio" name="attendance_option" value="solo_yo" style="accent-color: {{ $theme->primary_color }}">
                    <span class="option-text">Solo Yo</span>
                </label>
                <label class="attendance-option">
                    <input type="radio" name="attendance_option" value="yo_y_pareja" style="accent-color: {{ $theme->primary_color }}">
                    <span class="option-text">Yo y mi pareja</span>
                </label>
                <label class="attendance-option">
                    <input type="radio" name="attendance_option" value="no_asistire" style="accent-color: {{ $theme->primary_color }}">
                    <span class="option-text">No podré asistir</span>
                </label>
            </div>

            <div class="form-group">
                <textarea name="message" placeholder="Mensaje opcional..." rows="3" class="rsvp-input rsvp-textarea"
                          style="outline-color: {{ $theme->primary_color }}"></textarea>
            </div>

            <button type="submit" class="btn-primary rsvp-submit" style="background-color: {{ $theme->primary_color }}">
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
       class="btn-primary whatsapp-btn" style="background-color: #25D366">
        💬 ENVIAR MENSAJE
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
<footer class="invitation-footer" style="background-color: {{ $theme->primary_color }}">
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
