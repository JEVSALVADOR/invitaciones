@extends('layouts.admin')
@section('title', 'Editar Invitado')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.guests.update', $guest) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="guest_name" value="{{ old('guest_name', $guest->guest_name) }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asientos reservados *</label>
                <input type="number" name="seats_reserved" value="{{ old('seats_reserved', $guest->seats_reserved) }}" min="1" max="20" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $guest->phone) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $guest->email) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje personal</label>
                <textarea name="personal_message" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('personal_message', $guest->personal_message) }}</textarea>
            </div>

            @if($guest->guest_slug)
            <div class="p-3 bg-blue-50 rounded-lg border border-blue-200 text-sm">
                <p class="font-medium text-blue-700 mb-1">URL personalizada:</p>
                <code class="text-blue-600 text-xs break-all">{{ url('/i/'.$guest->event->uuid.'/'.$guest->guest_slug) }}</code>
            </div>
            @endif

            <div class="flex gap-3 justify-end pt-2">
                <a href="{{ route('admin.events.guests.index', $guest->event_id) }}"
                   class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600">Cancelar</a>
                <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
