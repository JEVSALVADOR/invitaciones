@extends('layouts.admin')
@section('title', 'Temas de Diseño')

@section('header-actions')
<a href="{{ route('admin.themes.create') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white"
   style="background-color: #1e3a5f">
    + Nuevo tema
</a>
@endsection

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($themes as $theme)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Theme preview bar -->
        <div class="h-16 flex" style="background-color: {{ $theme->background_color }}">
            <div class="w-1/3 h-full" style="background-color: {{ $theme->primary_color }}"></div>
            <div class="w-1/3 h-full" style="background-color: {{ $theme->secondary_color }}"></div>
            <div class="w-1/3 h-full" style="background-color: {{ $theme->accent_color }}"></div>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <h3 class="font-semibold text-gray-800">{{ $theme->name }}</h3>
                @if(!$theme->is_active)
                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Inactivo</span>
                @endif
            </div>
            <p class="text-xs text-gray-400 mb-3">
                Font: {{ $theme->font_script }} / {{ $theme->font_body }}<br>
                Floral: {{ $theme->floral_style }}<br>
                Eventos: {{ $theme->events_count }}
            </p>
            <div class="flex gap-2">
                <a href="{{ route('admin.themes.edit', $theme) }}"
                   class="text-xs px-3 py-1.5 rounded-lg text-white font-medium"
                   style="background-color: {{ $theme->primary_color }}">Editar</a>
                <form method="POST" action="{{ route('admin.themes.destroy', $theme) }}">
                    @csrf @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('¿Eliminar tema?')"
                            class="text-xs px-3 py-1.5 rounded-lg border border-red-200 text-red-500 hover:bg-red-50">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
