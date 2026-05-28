@extends('layouts.admin')
@section('title', 'Dashboard')

@section('header-actions')
<a href="{{ route('admin.events.create') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white"
   style="background-color: #1e3a5f">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Nuevo Evento
</a>
@endsection

@section('content')
<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $statCards = [
        ['label' => 'Total Eventos', 'value' => $stats['total_events'], 'icon' => '📅', 'color' => '#1e3a5f'],
        ['label' => 'Publicados', 'value' => $stats['published_events'], 'icon' => '✅', 'color' => '#16a34a'],
        ['label' => 'Total RSVP', 'value' => $stats['total_rsvp'], 'icon' => '💌', 'color' => '#7c3aed'],
        ['label' => 'Confirmados', 'value' => $stats['attending_rsvp'], 'icon' => '🎉', 'color' => '#c9a84c'],
    ];
    @endphp
    @foreach($statCards as $card)
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-2xl">{{ $card['icon'] }}</span>
            <span class="text-2xl font-bold" style="color: {{ $card['color'] }}">{{ $card['value'] }}</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Events -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Eventos Recientes</h2>
            <a href="{{ route('admin.events.index') }}" class="text-sm text-blue-600 hover:underline">Ver todos</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentEvents as $event)
            <div class="flex items-center gap-3 px-5 py-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                     style="background-color: {{ $event->theme->primary_color }}">
                    {{ strtoupper(substr($event->main_name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $event->event_title }}</p>
                    <p class="text-xs text-gray-400">{{ $event->event_date->locale('es')->isoFormat('D [de] MMMM, YYYY') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($event->is_published)
                    <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Publicado</span>
                    @else
                    <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">Borrador</span>
                    @endif
                    <a href="{{ route('admin.events.edit', $event) }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-gray-400 text-sm">
                No hay eventos aún.
                <a href="{{ route('admin.events.create') }}" class="text-blue-500 hover:underline ml-1">Crear uno</a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent RSVPs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Últimas Confirmaciones</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentRsvps as $rsvp)
            <div class="flex items-center gap-3 px-5 py-3">
                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($rsvp->respondent_name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $rsvp->respondent_name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $rsvp->event->main_name ?? '—' }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 {{ match($rsvp->attendance_option) {
                    'solo_yo' => 'bg-blue-100 text-blue-700',
                    'yo_y_pareja' => 'bg-green-100 text-green-700',
                    'no_asistire' => 'bg-red-100 text-red-600',
                    default => 'bg-gray-100 text-gray-500'
                } }}">
                    {{ match($rsvp->attendance_option) {
                        'solo_yo' => 'Solo yo',
                        'yo_y_pareja' => 'Con pareja',
                        'no_asistire' => 'No asistirá',
                        default => $rsvp->attendance_option
                    } }}
                </span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-gray-400 text-sm">No hay confirmaciones aún.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Upcoming Events -->
@if($upcomingEvents->count())
<div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-6">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">Próximos Eventos</h2>
    </div>
    <div class="p-5 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($upcomingEvents as $event)
        <div class="rounded-lg p-4 border-2 border-dashed" style="border-color: {{ $event->theme->accent_color }}40">
            <p class="text-sm font-bold" style="color: {{ $event->theme->primary_color }}">{{ $event->main_name }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $event->event_date->locale('es')->isoFormat('D [de] MMMM') }}</p>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('admin.events.edit', $event) }}"
                   class="text-xs px-3 py-1 rounded-lg text-white font-medium"
                   style="background-color: {{ $event->theme->primary_color }}">Editar</a>
                <a href="{{ route('invitation.show', $event->uuid) }}" target="_blank"
                   class="text-xs px-3 py-1 rounded-lg border font-medium text-gray-600 hover:bg-gray-50">Ver</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
