<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — Invitaciones Digitales</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center p-4">

<div class="w-full max-w-sm">
    <!-- Logo -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4"
             style="background-color: #c9a84c">
            <span class="text-white text-2xl">♥</span>
        </div>
        <h1 class="text-2xl font-bold text-white">Invitaciones</h1>
        <p class="text-white/50 text-sm mt-1">Panel Administrativo</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Iniciar sesión</h2>

        @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">
                    Correo electrónico
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2"
                       style="focus-ring-color: #1e3a5f">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                    Contraseña
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2">
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember"
                       class="w-4 h-4 rounded" style="accent-color: #1e3a5f">
                <label class="ml-2 text-sm text-gray-600" for="remember">Recordarme</label>
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-90"
                    style="background-color: #1e3a5f">
                Entrar al panel
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-6">
            Invitaciones Digitales © {{ date('Y') }}
        </p>
    </div>
</div>

</body>
</html>
