<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/* ─── Pública: Redirección raíz ────────────── */
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

/* ─── Invitaciones Públicas ─────────────────── */
Route::get('/i/{uuid}', [InvitationController::class, 'show'])
    ->name('invitation.show');

Route::get('/i/{uuid}/{guestSlug}', [InvitationController::class, 'showPersonalized'])
    ->name('invitation.personalized');

Route::post('/i/{uuid}/rsvp', [InvitationController::class, 'submitRsvp'])
    ->name('invitation.rsvp');

/* ─── Autenticación (Breeze) ────────────────── */
require __DIR__.'/auth.php';

/* ─── Panel Administrativo ──────────────────── */
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', [Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Eventos
        Route::resource('events', Admin\EventController::class);
        Route::post('events/{event}/publish', [Admin\EventController::class, 'publish'])
            ->name('events.publish');
        Route::post('events/{event}/media', [Admin\EventController::class, 'uploadMedia'])
            ->name('events.media.upload');
        Route::delete('events/{event}/media/{media}', [Admin\EventController::class, 'deleteMedia'])
            ->name('events.media.delete');
        Route::post('events/{event}/song', [Admin\EventController::class, 'uploadSong'])
            ->name('events.song.upload');
        Route::post('events/{event}/seal-initials', [Admin\EventController::class, 'updateSealInitials'])
            ->name('events.seal.initials');

        // Invitados
        Route::resource('events.guests', Admin\GuestController::class)
            ->shallow();
        Route::get('events/{event}/guests/export', [Admin\GuestController::class, 'export'])
            ->name('events.guests.export');

        // RSVP
        Route::get('events/{event}/rsvp', [Admin\RsvpController::class, 'index'])
            ->name('events.rsvp');
        Route::get('events/{event}/rsvp/export', [Admin\RsvpController::class, 'export'])
            ->name('events.rsvp.export');

        // Temas
        Route::resource('themes', Admin\ThemeController::class);

        // Perfil de usuario
        Route::get('profile', [Admin\ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('profile', [Admin\ProfileController::class, 'update'])
            ->name('profile.update');

        // API de ubicaciones e itinerario (usadas via AJAX en el editor)
        Route::post('locations', [Admin\LocationController::class, 'store'])
            ->name('locations.store');
        Route::post('locations/{location}', [Admin\LocationController::class, 'update'])
            ->name('locations.update');
        Route::delete('locations/{location}', [Admin\LocationController::class, 'destroy'])
            ->name('locations.destroy');

        Route::post('itinerary', [Admin\ItineraryController::class, 'store'])
            ->name('itinerary.store');
        Route::post('itinerary/{itinerary}', [Admin\ItineraryController::class, 'update'])
            ->name('itinerary.update');
        Route::delete('itinerary/{itinerary}', [Admin\ItineraryController::class, 'destroy'])
            ->name('itinerary.destroy');
        Route::post('itinerary/{itinerary}/icon', [Admin\ItineraryController::class, 'uploadIcon'])
            ->name('itinerary.icon.upload');
        Route::delete('itinerary/{itinerary}/icon', [Admin\ItineraryController::class, 'deleteIcon'])
            ->name('itinerary.icon.delete');
    });
