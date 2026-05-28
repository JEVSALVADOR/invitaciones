<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'                  => 'required|string|max:200',
            'email'                 => "required|email|unique:users,email,{$user->id}",
            'current_password'      => 'nullable|string',
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            }
        }

        $user->update(array_filter($validated, fn($v) => $v !== null));

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
