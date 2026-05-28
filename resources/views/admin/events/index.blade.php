@extends('layouts.admin')
@section('title', 'Eventos')

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
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50 text-left">
                <th class="px-5 py-3 font-semibold text-gray-600">Evento</th>
                <th class="px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">Tipo</th>
                <th class="px-5 py-3 font-semibold text-gray-600 hidden lg:table-cell">Fecha</th>
                <th class="px-5 py-3 font-semibold text-gray-600">Estado</th>
                <th class="px-5 py-3 font-semibold text-gray-600 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($events as $event)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                             style="background-color: {{ $event->theme->primary_color }}">
                            {{ strtoupper(substr($event->main_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $event->main_name }}
                                @if($event->second_name) & {{ $event->second_name }} @endif
                            </p>
                            <p class="text-xs text-gray-400">{{ $event->theme->name }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 hidden md:table-cell">
                    <span class="capitalize text-gray-600">{{ ucfirst($event->event_type) }}</span>
                </td>
                <td class="px-5 py-4 hidden lg:table-cell text-gray-600">
                    {{ $event->event_date->locale('es')->isoFormat('D MMM YYYY') }}
                </td>
                <td class="px-5 py-4">
                    <form method="POST" action="{{ route('admin.events.publish', $event) }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-xs px-2.5 py-1 rounded-full font-medium transition-colors {{ $event->is_published ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                            {{ $event->is_published ? '✓ Publicado' : 'Borrador' }}
                        </button>
                    </form>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        @if($event->is_published)
                        <a href="{{ route('invitation.show', $event->uuid) }}" target="_blank"
                           class="text-gray-400 hover:text-gray-600" title="Ver invitación">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        @endif
                        <a href="{{ route('admin.events.guests.index', $event) }}"
                           class="text-gray-400 hover:text-gray-600" title="Invitados">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.events.rsvp', $event) }}"
                           class="text-gray-400 hover:text-gray-600" title="RSVP">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}"
                           class="text-blue-500 hover:text-blue-700" title="Editar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                              onsubmit="return confirm('¿Eliminar este evento y todos sus datos?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600" title="Eliminar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                    No hay eventos.
                    <a href="{{ route('admin.events.create') }}" class="text-blue-500 hover:underline">Crear el primero</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($events->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
