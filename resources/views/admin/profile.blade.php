@extends('layouts.admin')
@section('title', 'Mi Perfil')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PATCH')

        <h2 class="text-base font-semibold text-gray-800">Información de la cuenta</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
            <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
            <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <hr class="border-gray-100">

        <h3 class="text-sm font-semibold text-gray-700">Cambiar contraseña <span class="font-normal text-gray-400">(opcional)</span></h3>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label>
            <input type="password" name="current_password"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('current_password')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                <input type="password" name="password"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">
                Guardar cambios
            </button>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-1">Detalles de la sesión</h2>
        <dl class="text-sm text-gray-600 space-y-1 mt-3">
            <div class="flex gap-2">
                <dt class="font-medium text-gray-500 w-24">Rol:</dt>
                <dd class="capitalize">{{ $user->role }}</dd>
            </div>
            <div class="flex gap-2">
                <dt class="font-medium text-gray-500 w-24">Cuenta creada:</dt>
                <dd>{{ $user->created_at?->format('d/m/Y') ?? '—' }}</dd>
            </div>
        </dl>
    </div>

</div>
@endsection
