@php
// Inline SVG florals as placeholders (replace with PNG images in production)
// Colors mapped to theme styles
$colorMap = [
    'navy_blue'  => ['#1e3a5f', '#4a90d9', '#c9a84c', '#7fb3e8'],
    'pink_roses' => ['#8b2252', '#d4608a', '#d4a853', '#f0a0c0'],
    'gold_garden'=> ['#4a3520', '#8b7355', '#c9a84c', '#d4b896'],
    'rustic'     => ['#5c3d1e', '#8b6240', '#c9a84c', '#d4b896'],
    'tropical'   => ['#1a5c3a', '#2e9e62', '#f5c842', '#80d4a8'],
];
$colors = $colorMap[$style] ?? $colorMap['navy_blue'];
[$c1, $c2, $c3, $c4] = $colors;
@endphp

@if($position === 'top-left')
<svg viewBox="0 0 300 280" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto">
    <!-- Large branch -->
    <path d="M-10 280 Q40 200 80 150 Q120 100 150 60 Q170 30 140 10" stroke="{{ $c1 }}" stroke-width="3" fill="none" opacity="0.6"/>
    <!-- Flowers -->
    <circle cx="90" cy="140" r="22" fill="{{ $c3 }}" opacity="0.25"/>
    <circle cx="90" cy="140" r="14" fill="{{ $c3 }}" opacity="0.5"/>
    <circle cx="90" cy="140" r="7" fill="{{ $c3 }}" opacity="0.9"/>
    <circle cx="120" cy="100" r="18" fill="{{ $c2 }}" opacity="0.2"/>
    <circle cx="120" cy="100" r="11" fill="{{ $c2 }}" opacity="0.45"/>
    <circle cx="120" cy="100" r="6" fill="{{ $c2 }}" opacity="0.8"/>
    <circle cx="55" cy="180" r="14" fill="{{ $c3 }}" opacity="0.3"/>
    <circle cx="55" cy="180" r="8" fill="{{ $c3 }}" opacity="0.6"/>
    <!-- Leaves -->
    <ellipse cx="105" cy="165" rx="12" ry="6" fill="{{ $c1 }}" opacity="0.4" transform="rotate(-30 105 165)"/>
    <ellipse cx="70" cy="130" rx="10" ry="5" fill="{{ $c1 }}" opacity="0.35" transform="rotate(20 70 130)"/>
    <ellipse cx="140" cy="80" rx="11" ry="5" fill="{{ $c1 }}" opacity="0.4" transform="rotate(-50 140 80)"/>
    <!-- Small petals around main flower -->
    @for($i = 0; $i < 6; $i++)
    <ellipse cx="{{ 90 + 18*cos(deg2rad(60*$i)) }}" cy="{{ 140 + 18*sin(deg2rad(60*$i)) }}" rx="7" ry="4" fill="{{ $c3 }}" opacity="0.5" transform="rotate({{ 60*$i }} {{ 90 + 18*cos(deg2rad(60*$i)) }} {{ 140 + 18*sin(deg2rad(60*$i)) }})"/>
    @endfor
    <!-- Dots/berries -->
    <circle cx="60" cy="155" r="3" fill="{{ $c3 }}" opacity="0.7"/>
    <circle cx="75" cy="158" r="2.5" fill="{{ $c3 }}" opacity="0.6"/>
    <circle cx="110" cy="125" r="2.5" fill="{{ $c2 }}" opacity="0.7"/>
</svg>

@elseif($position === 'bottom-right')
<svg viewBox="0 0 280 260" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto;transform:scale(-1,1)">
    <path d="M-10 280 Q40 200 80 150 Q120 100 150 60 Q170 30 140 10" stroke="{{ $c1 }}" stroke-width="3" fill="none" opacity="0.6"/>
    <circle cx="90" cy="140" r="20" fill="{{ $c3 }}" opacity="0.25"/>
    <circle cx="90" cy="140" r="12" fill="{{ $c3 }}" opacity="0.5"/>
    <circle cx="90" cy="140" r="6" fill="{{ $c3 }}" opacity="0.9"/>
    <circle cx="118" cy="102" r="16" fill="{{ $c2 }}" opacity="0.2"/>
    <circle cx="118" cy="102" r="10" fill="{{ $c2 }}" opacity="0.45"/>
    <circle cx="118" cy="102" r="5" fill="{{ $c2 }}" opacity="0.8"/>
    <ellipse cx="105" cy="163" rx="11" ry="5" fill="{{ $c1 }}" opacity="0.4" transform="rotate(-30 105 163)"/>
    <ellipse cx="70" cy="128" rx="9" ry="4" fill="{{ $c1 }}" opacity="0.35" transform="rotate(20 70 128)"/>
    <circle cx="60" cy="155" r="3" fill="{{ $c3 }}" opacity="0.7"/>
    <circle cx="75" cy="158" r="2.5" fill="{{ $c3 }}" opacity="0.6"/>
</svg>

@elseif($position === 'envelope')
<svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto">
    <path d="M10 160 Q50 120 80 90 Q110 60 130 30" stroke="{{ $c1 }}" stroke-width="2.5" fill="none" opacity="0.7"/>
    <circle cx="75" cy="95" r="16" fill="{{ $c3 }}" opacity="0.3"/>
    <circle cx="75" cy="95" r="10" fill="{{ $c3 }}" opacity="0.6"/>
    <circle cx="75" cy="95" r="5" fill="{{ $c3 }}" opacity="0.95"/>
    <ellipse cx="90" cy="112" rx="9" ry="4" fill="{{ $c1 }}" opacity="0.5" transform="rotate(-25 90 112)"/>
    <ellipse cx="58" cy="78" rx="8" ry="3.5" fill="{{ $c1 }}" opacity="0.4" transform="rotate(15 58 78)"/>
    <circle cx="50" cy="120" r="2.5" fill="{{ $c3 }}" opacity="0.7"/>
    <circle cx="100" cy="70" r="2" fill="{{ $c2 }}" opacity="0.7"/>
</svg>

@elseif($position === 'divider')
<svg viewBox="0 0 400 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto">
    <path d="M0 40 Q50 20 100 40 Q150 60 200 40 Q250 20 300 40 Q350 60 400 40" stroke="{{ $c2 }}" stroke-width="1.5" fill="none" opacity="0.4"/>
    <circle cx="200" cy="40" r="14" fill="{{ $c3 }}" opacity="0.25"/>
    <circle cx="200" cy="40" r="9" fill="{{ $c3 }}" opacity="0.5"/>
    <circle cx="200" cy="40" r="5" fill="{{ $c3 }}" opacity="0.9"/>
    <circle cx="130" cy="38" r="9" fill="{{ $c2 }}" opacity="0.2"/>
    <circle cx="130" cy="38" r="5" fill="{{ $c2 }}" opacity="0.5"/>
    <circle cx="270" cy="38" r="9" fill="{{ $c2 }}" opacity="0.2"/>
    <circle cx="270" cy="38" r="5" fill="{{ $c2 }}" opacity="0.5"/>
    <ellipse cx="180" cy="52" rx="8" ry="3" fill="{{ $c1 }}" opacity="0.35" transform="rotate(-20 180 52)"/>
    <ellipse cx="220" cy="52" rx="8" ry="3" fill="{{ $c1 }}" opacity="0.35" transform="rotate(20 220 52)"/>
</svg>

@elseif($position === 'cal-corner' || $position === 'cal-corner-br')
<svg viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto" @if($position === 'cal-corner-br') transform="scale(-1,-1)" @endif>
    <path d="M0 100 Q30 70 55 45 Q75 25 90 5" stroke="{{ $c1 }}" stroke-width="2" fill="none" opacity="0.5"/>
    <circle cx="52" cy="48" r="12" fill="{{ $c3 }}" opacity="0.25"/>
    <circle cx="52" cy="48" r="7" fill="{{ $c3 }}" opacity="0.55"/>
    <circle cx="52" cy="48" r="4" fill="{{ $c3 }}" opacity="0.9"/>
    <ellipse cx="64" cy="60" rx="7" ry="3" fill="{{ $c1 }}" opacity="0.4" transform="rotate(-25 64 60)"/>
    <circle cx="35" cy="70" r="5" fill="{{ $c2 }}" opacity="0.3"/>
    <circle cx="35" cy="70" r="3" fill="{{ $c2 }}" opacity="0.6"/>
</svg>

@else
<svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto">
    <circle cx="50" cy="50" r="20" fill="{{ $c3 }}" opacity="0.3"/>
    <circle cx="50" cy="50" r="12" fill="{{ $c3 }}" opacity="0.6"/>
    <circle cx="50" cy="50" r="6" fill="{{ $c3 }}" opacity="0.9"/>
</svg>
@endif
