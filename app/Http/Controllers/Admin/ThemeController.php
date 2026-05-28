<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeController extends Controller
{
    public function index(): View
    {
        $themes = Theme::withCount('events')->get();
        return view('admin.themes.index', compact('themes'));
    }

    public function create(): View
    {
        return view('admin.themes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        Theme::create($validated);
        return redirect()->route('admin.themes.index')->with('success', 'Tema creado.');
    }

    public function edit(Theme $theme): View
    {
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme): RedirectResponse
    {
        $validated = $request->validate($this->rules($theme->id));
        $theme->update($validated);
        return redirect()->route('admin.themes.index')->with('success', 'Tema actualizado.');
    }

    public function destroy(Theme $theme): RedirectResponse
    {
        if ($theme->events()->exists()) {
            return back()->with('error', 'No se puede eliminar un tema con eventos asociados.');
        }
        $theme->delete();
        return redirect()->route('admin.themes.index')->with('success', 'Tema eliminado.');
    }

    private function rules(?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:100|unique:themes,slug' . ($ignoreId ? ",{$ignoreId}" : '');
        return [
            'name'             => 'required|string|max:100',
            'slug'             => $slugRule,
            'primary_color'    => 'required|string|max:7',
            'secondary_color'  => 'required|string|max:7',
            'accent_color'     => 'required|string|max:7',
            'background_color' => 'required|string|max:7',
            'text_color'       => 'required|string|max:7',
            'font_script'      => 'required|string|max:100',
            'font_display'     => 'required|string|max:100',
            'font_body'        => 'required|string|max:100',
            'floral_style'     => 'required|in:navy_blue,pink_roses,gold_garden,rustic,tropical',
            'envelope_color'   => 'required|string|max:7',
            'seal_color'       => 'required|string|max:7',
            'is_active'        => 'boolean',
        ];
    }
}
