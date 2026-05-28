@extends('layouts.admin')
@section('title', 'Crear Tema')

@section('content')
<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('admin.themes.store') }}" class="space-y-5">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug *</label>
                    <input type="text" name="slug" required value="{{ old('slug') }}" placeholder="mi-tema-elegante"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Paleta de colores</p>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                    @foreach(['primary_color' => 'Principal', 'secondary_color' => 'Secundario', 'accent_color' => 'Acento', 'background_color' => 'Fondo', 'text_color' => 'Texto'] as $field => $label)
                    <div class="text-center">
                        <input type="color" name="{{ $field }}" value="{{ old($field, '#1e3a5f') }}"
                               class="w-10 h-10 rounded cursor-pointer border border-gray-200 block mx-auto mb-1">
                        <label class="text-xs text-gray-500">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Colores del sobre</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex items-center gap-3">
                        <input type="color" name="envelope_color" value="{{ old('envelope_color', '#1e3a5f') }}" class="w-10 h-10 rounded border border-gray-200">
                        <label class="text-sm text-gray-600">Sobre</label>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="color" name="seal_color" value="{{ old('seal_color', '#c9a84c') }}" class="w-10 h-10 rounded border border-gray-200">
                        <label class="text-sm text-gray-600">Lacre</label>
                    </div>
                </div>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fuente script</label>
                    <input type="text" name="font_script" value="{{ old('font_script', 'Great Vibes') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fuente display</label>
                    <input type="text" name="font_display" value="{{ old('font_display', 'Playfair Display') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fuente cuerpo</label>
                    <input type="text" name="font_body" value="{{ old('font_body', 'Lato') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estilo floral</label>
                <select name="floral_style" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach(['navy_blue' => 'Azul marino', 'pink_roses' => 'Rosas rosadas', 'gold_garden' => 'Jardín dorado', 'rustic' => 'Rústico', 'tropical' => 'Tropical'] as $val => $lbl)
                    <option value="{{ $val }}" {{ old('floral_style') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked style="accent-color: #1e3a5f">
                <span class="text-sm text-gray-700">Tema activo</span>
            </label>
        </div>
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.themes.index') }}" class="px-4 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600">Cancelar</a>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background-color: #1e3a5f">Crear tema</button>
        </div>
    </form>
</div>
@endsection
