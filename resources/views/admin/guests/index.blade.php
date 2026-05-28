@extends('layouts.admin')
@section('title', 'Invitados — ' . $event->main_name)

@section('header-actions')
<div class="flex gap-2">
    <a href="{{ route('admin.events.guests.export', $event) }}"
       class="inline-flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50">
        📥 Exportar CSV
    </a>
    <a href="{{ route('admin.events.guests.create', $event) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white"
       style="background-color: #1e3a5f">
        + Agregar
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Nombre</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden sm:table-cell">Asientos</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">URL</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden lg:table-cell">RSVP</th>
                <th class="px-4 py-3 text-right font-semibold text-gray-600">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($guests as $guest)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-800">{{ $guest->guest_name }}</p>
                    @if($guest->phone) <p class="text-xs text-gray-400">{{ $guest->phone }}</p> @endif
                </td>
                <td class="px-4 py-3 hidden sm:table-cell text-gray-600">{{ $guest->seats_reserved }}</td>
                <td class="px-4 py-3 hidden md:table-cell">
                    @if($guest->guest_slug)
                    <button onclick="navigator.clipboard.writeText('{{ url('/i/'.$event->uuid.'/'.$guest->guest_slug) }}').then(()=>alert('¡URL copiada!'))"
                            class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded text-gray-600">
                        📋 Copiar URL
                    </button>
                    @endif
                </td>
                <td class="px-4 py-3 hidden lg:table-cell">
                    @if($guest->rsvpResponse)
                    <span class="text-xs px-2 py-0.5 rounded-full {{ match($guest->rsvpResponse->attendance_option) {
                        'solo_yo' => 'bg-blue-100 text-blue-700',
                        'yo_y_pareja' => 'bg-green-100 text-green-700',
                        'no_asistire' => 'bg-red-100 text-red-600',
                        default => ''
                    } }}">
                        {{ match($guest->rsvpResponse->attendance_option) {
                            'solo_yo' => 'Asiste (1)',
                            'yo_y_pareja' => 'Asiste (2)',
                            'no_asistire' => 'No asiste',
                            default => ''
                        } }}
                    </span>
                    @else
                    <span class="text-xs text-gray-400">Sin respuesta</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.guests.edit', $guest) }}" class="text-blue-500 hover:text-blue-700 text-xs">Editar</a>
                        <form method="POST" action="{{ route('admin.guests.destroy', $guest) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar?')" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                    No hay invitados.
                    <a href="{{ route('admin.events.guests.create', $event) }}" class="text-blue-500 hover:underline">Agregar el primero</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($guests->hasPages())
    <div class="px-4 py-3 border-t">{{ $guests->links() }}</div>
    @endif
</div>
@endsection
