<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventGuest;
use App\Models\EventItinerary;
use App\Models\EventLocation;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $theme = Theme::where('slug', 'navy-blue-elegant')->first();

        $event = Event::firstOrCreate(
            ['uuid' => 'demo-sofia-2025'],
            [
                'theme_id'     => $theme->id,
                'event_type'   => 'quinceanera',
                'main_name'    => 'Sofía Valentina',
                'second_name'  => null,
                'event_date'   => '2025-08-16',
                'ceremony_time' => '16:00:00',
                'reception_time' => '18:00:00',
                'love_message' => 'Hoy, al cumplir mis quince años, celebro no solo el tiempo transcurrido, sino cada momento vivido junto a quienes más amo. Este día tan especial es posible gracias al amor incondicional de mi familia y mis amigos, quienes han iluminado cada paso de mi camino.',
                'bible_verse'  => 'Porque yo sé los planes que tengo para ustedes, planes de bienestar y no de calamidad, para darles un futuro y una esperanza.',
                'bible_reference' => 'Jeremías 29:11',
                'show_music_player'    => true,
                'show_dress_code'      => true,
                'show_gift_suggestion' => true,
                'show_recommendations' => true,
                'show_rsvp'            => true,
                'show_countdown'       => true,
                'show_itinerary'       => true,
                'dress_code_general'   => 'Formal / Coctel',
                'dress_code_women'     => 'Vestido largo o coctel en tonos pasteles, azul marino, rosado o dorado. Evitar color blanco o rojo.',
                'dress_code_men'       => 'Traje formal o camisa con pantalón de vestir. Corbata o moño opcional.',
                'gift_suggestion_text' => 'Tu presencia es el mejor regalo. Sin embargo, si deseas obsequiarme algo, puedes hacerlo a través de una lluvia de sobres que estarán disponibles en la recepción. ¡Gracias por tu generosidad!',
                'recommendations'      => [
                    ['icon' => 'children', 'text' => 'Por respeto a todos los invitados, el evento es exclusivo para adultos. Agradecemos tu comprensión.'],
                    ['icon' => 'phone', 'text' => 'Durante la ceremonia, por favor mantén tu teléfono en silencio y disfruta del momento.'],
                    ['icon' => 'clock', 'text' => 'Te pedimos puntualidad. La ceremonia comenzará a las 4:00 PM en punto.'],
                    ['icon' => 'car', 'text' => 'El salón cuenta con estacionamiento gratuito para todos los asistentes.'],
                ],
                'contact_whatsapp' => '+523312345678',
                'contact_name'     => 'Mamá de Sofía',
                'song_title'       => 'A Thousand Years',
                'song_artist'      => 'Christina Perri',
                'is_published'     => true,
                'total_seats'      => 200,
            ]
        );

        // Locations
        if ($event->locations()->count() === 0) {
            EventLocation::insert([
                [
                    'event_id'      => $event->id,
                    'location_type' => 'MISA DE ACCIÓN DE GRACIAS',
                    'venue_name'    => 'Parroquia San Miguel Arcángel',
                    'address'       => 'Av. Independencia 450, Col. Centro',
                    'city'          => 'Guadalajara, Jalisco',
                    'google_maps_url' => 'https://maps.google.com',
                    'event_time'    => '16:00:00',
                    'sort_order'    => 1,
                    'created_at'    => now(),
                ],
                [
                    'event_id'      => $event->id,
                    'location_type' => 'RECEPCIÓN Y FIESTA',
                    'venue_name'    => 'Salón Jardines del Rey',
                    'address'       => 'Blvd. Marcelino García Barragán 1234',
                    'city'          => 'Guadalajara, Jalisco',
                    'google_maps_url' => 'https://maps.google.com',
                    'event_time'    => '18:00:00',
                    'sort_order'    => 2,
                    'created_at'    => now(),
                ],
            ]);
        }

        // Itinerary
        if ($event->itinerary()->count() === 0) {
            $items = [
                ['time_label' => '4:00 PM', 'event_time' => '16:00:00', 'activity_name' => 'MISA DE ACCIÓN DE GRACIAS', 'icon_type' => 'church', 'position' => 'right', 'sort_order' => 1],
                ['time_label' => '5:30 PM', 'event_time' => '17:30:00', 'activity_name' => 'SESIÓN DE FOTOS', 'icon_type' => 'camera', 'position' => 'left', 'sort_order' => 2],
                ['time_label' => '6:00 PM', 'event_time' => '18:00:00', 'activity_name' => 'RECEPCIÓN DE INVITADOS', 'icon_type' => 'reception_table', 'position' => 'right', 'sort_order' => 3],
                ['time_label' => '7:00 PM', 'event_time' => '19:00:00', 'activity_name' => 'VALS Y PRESENTACIÓN', 'icon_type' => 'dance', 'position' => 'left', 'sort_order' => 4],
                ['time_label' => '8:00 PM', 'event_time' => '20:00:00', 'activity_name' => 'CENA', 'icon_type' => 'dinner', 'position' => 'right', 'sort_order' => 5],
                ['time_label' => '9:00 PM', 'event_time' => '21:00:00', 'activity_name' => 'BRINDIS Y PASTEL', 'icon_type' => 'cake', 'position' => 'left', 'sort_order' => 6],
                ['time_label' => '9:30 PM', 'event_time' => '21:30:00', 'activity_name' => 'BAILE Y FIESTA', 'icon_type' => 'party', 'position' => 'right', 'sort_order' => 7],
            ];

            foreach ($items as $item) {
                EventItinerary::create(array_merge($item, ['event_id' => $event->id]));
            }
        }

        // Sample guests
        if ($event->guests()->count() === 0) {
            $guests = [
                ['guest_name' => 'Familia Martínez López', 'seats_reserved' => 4, 'phone' => '+523398765432'],
                ['guest_name' => 'Señora Claudia Rodríguez', 'seats_reserved' => 2, 'phone' => '+523387654321'],
                ['guest_name' => 'Familia González Pérez', 'seats_reserved' => 3, 'email' => 'gonzalez@ejemplo.com'],
            ];

            foreach ($guests as $guest) {
                EventGuest::create(array_merge($guest, ['event_id' => $event->id]));
            }
        }
    }
}
