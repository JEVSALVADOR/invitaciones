@if(!empty($icon_image))
<img src="{{ Storage::url($icon_image) }}"
     alt=""
     style="width:32px;height:32px;object-fit:contain;display:block;">
@else
@php
$icons = [
    'church' => '<path d="M10 2v2H8v2h2v1H6v2h4v9h4v-9h4V9h-4V7h2V5h-2V2h-4zm0 4h4v1h-4V6z" fill="currentColor"/>',
    'camera' => '<path d="M12 15.2A3.2 3.2 0 0 1 8.8 12 3.2 3.2 0 0 1 12 8.8 3.2 3.2 0 0 1 15.2 12 3.2 3.2 0 0 1 12 15.2M9 3L7.17 5H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-3.17L15 3H9z" fill="currentColor"/>',
    'reception_table' => '<path d="M4 16v2h16v-2H4m16-8H4v2h7v4h2v-4h7V8z" fill="currentColor"/>',
    'flowers_table'   => '<path d="M12 22q-3.475-1.025-5.737-4.037Q4 14.95 4 11.4V5l8-3 8 3v6.4q0 3.55-2.263 6.563Q15.475 20.975 12 22zm0-5q1.65 0 2.825-1.175Q16 14.65 16 13q0-1.65-1.175-2.825Q13.65 9 12 9q-1.65 0-2.825 1.175Q8 11.35 8 13q0 1.65 1.175 2.825Q10.35 17 12 17z" fill="currentColor"/>',
    'car'  => '<path d="M5 11l1.5-4.5h11L19 11M17.5 16a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 17.5 13a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 17.5 16m-11 0A1.5 1.5 0 0 1 5 14.5 1.5 1.5 0 0 1 6.5 13 1.5 1.5 0 0 1 8 14.5 1.5 1.5 0 0 1 6.5 16M18.92 6A2 2 0 0 0 17 5H7a2 2 0 0 0-1.92 1.38L3 12v8a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-8l-2.08-6z" fill="currentColor"/>',
    'ring' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-12.5c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 5.5c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" fill="currentColor"/>',
    'cake' => '<path d="M12 6c1.11 0 2-.89 2-2 0-.5-.17-.97-.46-1.34L12 1l-1.54 1.66C10.17 3.03 10 3.5 10 4c0 1.11.89 2 2 2zm4 3H8c-1.1 0-2 .9-2 2v1h12v-1c0-1.1-.9-2-2-2zM4 19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-5H4v5z" fill="currentColor"/>',
    'party' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H7l5-8v4h4l-5 8z" fill="currentColor"/>',
    'dance' => '<path d="M14.5 3.5c0 1.5-1.01 2.24-1.68 3H11c-.67-.76-1.68-1.5-1.68-3a2.5 2.5 0 0 1 5 0zM9.5 9l-1.5 6H6l1.85-6H9.5zm6.5 0l-1.5 6h2L18 9h-2z" fill="currentColor"/>',
    'dinner' => '<path d="M18.06 22.99h1.66c.84 0 1.53-.64 1.63-1.46L23 5.05h-5V1h-1.97v4.05h-4.97l.3 2.34c1.71.47 3.31 1.32 4.27 2.26 1.44 1.42 2.43 2.89 2.43 5.29v8.05zM1 21.99V21h15.03v.99c0 .55-.45 1-1.01 1H2.01c-.56 0-1.01-.45-1.01-1zm15.03-7H1v-2h15.03v2zm0-4H1v-2h15.03v2z" fill="currentColor"/>',
    'toast' => '<path d="M20 3H4v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h2c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2zm0 5h-2V5h2v3zM4 19h16v2H4v-2z" fill="currentColor"/>',
    'custom' => '<circle cx="12" cy="12" r="5" fill="currentColor"/>',
];
$path = $icons[$type] ?? $icons['custom'];
@endphp
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" style="color: {{ $theme->accent_color ?? '#c9a84c' }}">
    {!! $path !!}
</svg>
@endif
