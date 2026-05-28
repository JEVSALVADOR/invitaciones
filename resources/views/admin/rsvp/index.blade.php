@extends('layouts.admin')
@section('title', 'RSVP — ' . $event->main_name)

@section('header-actions')
<a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Volver</a>
@endsection

@section('content')
<!-- Stats -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Total respuestas</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
        <p class="text-2xl font-bold text-blue-600">{{ $stats['solo_yo'] + $stats['yo_y_pareja'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Confirman asistencia</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
        <p class="text-2xl font-bold text-red-500">{{ $stats['no_asistire'] }}</p>
        <p class="text-xs text-gray-500 mt-1">No asistirán</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
        <p class="text-2xl font-bold" style="color: #c9a84c">{{ $stats['total_seats'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Lugares confirmados</p>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Nombre</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">Asistencia</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden lg:table-cell">Mensaje</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600 hidden sm:table-cell">Fecha</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($responses as $rsvp)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-800">{{ $rsvp->respondent_name }}</p>
                    @if($rsvp->guest) <p class="text-xs text-gray-400">Invitado: {{ $rsvp->guest->guest_name }}</p> @endif
                    @if($rsvp->phone_contact) <p class="text-xs text-gray-400">{{ $rsvp->phone_contact }}</p> @endif
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-xs px-2 py-1 rounded-full font-medium {{ match($rsvp->attendance_option) {
                        'solo_yo' => 'bg-blue-100 text-blue-700',
                        'yo_y_pareja' => 'bg-green-100 text-green-700',
                        'no_asistire' => 'bg-red-100 text-red-600',
                        default => 'bg-gray-100 text-gray-500'
                    } }}">
                        {{ match($rsvp->attendance_option) {
                            'solo_yo' => '1 persona',
                            'yo_y_pareja' => '2 personas',
                            'no_asistire' => 'No asiste',
                            default => $rsvp->attendance_option
                        } }}
                    </span>
                </td>
                <td class="px-4 py-3 hidden lg:table-cell text-gray-500 text-sm max-w-xs truncate">
                    {{ $rsvp->message ?? '—' }}
                </td>
                <td class="px-4 py-3 hidden sm:table-cell text-xs text-gray-400">
                    {{ $rsvp->responded_at->locale('es')->isoFormat('D MMM, HH:mm') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-400">Sin respuestas aún.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($responses->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $responses->links() }}</div>
    @endif
</div>
@endsection
