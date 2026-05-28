@extends('layouts.admin')
@section('title', 'Agregar Invitado')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-800 mb-5">Nuevo invitado — {{ $event->main_name }}</h2>

        <form method="POST" action="{{ route('admin.events.guests.store', $event) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del invitado / familia *</label>
                <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                       placeholder="Ej: Familia Martínez López"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asientos reservados *</label>
                <input type="number" name="seats_reserved" value="{{ old('seats_reserved', 1) }}" min="1" max="20" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="+52 33 1234 5678"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje personal <span class="text-gray-400">(aparece en su invitación)</span></label>
                <textarea name="personal_message" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('personal_message') }}</textarea>
            </div>
            <div class="flex gap-3 justify-end pt-2">
                <a href="{{ route('admin.events.guests.index', $event) }}"
                   class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600">Cancelar</a>
                <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">
                    Agregar invitado
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
