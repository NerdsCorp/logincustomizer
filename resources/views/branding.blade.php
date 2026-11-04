@php
    $title = $settings['title'] ?? '';
    $message = $settings['message'] ?? '';
    $logo = $settings['logo_url'] ?? '';
    $background = $settings['background_url'] ?? '';
    $backgroundType = in_array($settings['background_type'] ?? 'auto', ['auto', 'image', 'video'], true) ? ($settings['background_type'] ?? 'auto') : 'auto';
    $backgroundPath = parse_url($background, PHP_URL_PATH) ?: '';
    $backgroundExtension = strtolower(pathinfo($backgroundPath, PATHINFO_EXTENSION));
    $isVideoBackground = $background !== '' && ($backgroundType === 'video' || ($backgroundType === 'auto' && in_array($backgroundExtension, ['mp4', 'webm', 'ogg'], true)));
    $accent = $settings['accent_color'] ?? '';
    $pageColor = $settings['page_color'] ?? '';
    $cardColor = $settings['card_color'] ?? '';
    $cardOpacity = is_numeric($settings['card_opacity'] ?? null) ? max(0, min(100, (int) $settings['card_opacity'])) : null;
    $cardRadius = is_numeric($settings['card_radius'] ?? null) ? max(0, min(64, (int) $settings['card_radius'])) : null;
    $cardWidth = is_numeric($settings['card_width'] ?? null) ? max(280, min(1000, (int) $settings['card_width'])) : null;
    $logoWidth = is_numeric($settings['logo_width'] ?? null) ? max(40, min(1200, (int) $settings['logo_width'])) : 320;
    $logoHeight = is_numeric($settings['logo_height'] ?? null) ? max(20, min(600, (int) $settings['logo_height'])) : 80;
    $font = $settings['font_family'] ?? '';
    $textColor = $settings['text_color'] ?? '';
    $buttonTextColor = $settings['button_text_color'] ?? '';
    $linkColor = $settings['link_color'] ?? '';
    $overrideThemes = filter_var($settings['override_themes'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $alignment = in_array($settings['alignment'] ?? 'center', ['left', 'center', 'right'], true) ? $settings['alignment'] : 'center';
@endphp

<style>
    @if ($pageColor)
        body {
            background-color: {{ $pageColor }};
        }
    @endif
    @if ($background)
        body { isolation: isolate; }
        .login-customizer-background { position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; }
        .login-customizer-background video { display: block; width: 100%; height: 100%; object-fit: cover; }
        @if (!$isVideoBackground)
            .login-customizer-background { background-image: linear-gradient(rgb(0 0 0 / 30%), rgb(0 0 0 / 30%)), url("{{ $background }}"); background-size: cover; background-position: center; background-repeat: no-repeat; }
        @endif
    @endif
    @if ($accent)
        :root { --primary-50: {{ $accent }}; --primary-100: {{ $accent }}; --primary-500: {{ $accent }}; --primary-600: {{ $accent }}; --primary-700: {{ $accent }}; }
    @endif
    @if ($logo) .fi-simple-header .fi-logo { display: none; } @endif
    .fi-simple-main {
        @if ($cardColor && $cardOpacity !== null) background-color: color-mix(in srgb, {{ $cardColor }} {{ $cardOpacity }}%, transparent); @elseif ($cardColor) background-color: {{ $cardColor }}; @endif
        @if ($cardRadius !== null) border-radius: {{ $cardRadius }}px; @endif
        @if ($cardWidth !== null) width: min(100%, {{ $cardWidth }}px); @endif
    }
    .fi-simple-page, .fi-simple-main, .fi-simple-header { text-align: {{ $alignment }}; }
    @if ($font) body, button, input { font-family: {{ $font }}, sans-serif; } @endif
    @if ($textColor) .fi-simple-main, .fi-simple-header { color: {{ $textColor }}; } @endif
    @if ($buttonTextColor) .fi-simple-main button[type="submit"] { color: {{ $buttonTextColor }}; } @endif
    @if ($linkColor) .fi-simple-main a { color: {{ $linkColor }}; } @endif
    @if ($overrideThemes)
        html.dark, .dark {
            @if ($accent) --primary-50: {{ $accent }} !important; --primary-100: {{ $accent }} !important; --primary-500: {{ $accent }} !important; --primary-600: {{ $accent }} !important; --primary-700: {{ $accent }} !important; @endif
        }
        @if ($pageColor)
            html.dark body, body.dark {
                background-color: {{ $pageColor }} !important;
            }
        @endif
        @if ($cardColor)
            html.dark .fi-simple-main, .dark .fi-simple-main {
                @if ($cardOpacity !== null) background-color: color-mix(in srgb, {{ $cardColor }} {{ $cardOpacity }}%, transparent) !important; @else background-color: {{ $cardColor }} !important; @endif
            }
        @endif
        @if ($textColor) html.dark .fi-simple-main, .dark .fi-simple-main, html.dark .fi-simple-main *, .dark .fi-simple-main *, html.dark .fi-simple-header, .dark .fi-simple-header, html.dark .fi-simple-header * { color: {{ $textColor }} !important; } @endif
        @if ($buttonTextColor) html.dark .fi-simple-main button[type="submit"], .dark .fi-simple-main button[type="submit"] { color: {{ $buttonTextColor }} !important; } @endif
        @if ($linkColor) html.dark .fi-simple-main a, .dark .fi-simple-main a { color: {{ $linkColor }} !important; } @endif
        @if ($font) html.dark body, body.dark, .dark button, .dark input { font-family: {{ $font }}, sans-serif !important; } @endif
    @endif
    {!! $settings['custom_css'] ?? '' !!}
</style>

@if ($background && $isVideoBackground)
    <div class="login-customizer-background" aria-hidden="true">
        <video src="{{ $background }}" autoplay muted loop playsinline preload="auto" tabindex="-1"></video>
    </div>
@elseif ($background)
    <div class="login-customizer-background" aria-hidden="true"></div>
@endif

<div class="login-customizer-branding" style="text-align: {{ $alignment }}; margin: 0 auto 1rem; max-width: {{ $cardWidth ?? 480 }}px">
    @if ($logo)
        <img src="{{ $logo }}" alt="{{ $title ?: config('app.name') }}" style="display: inline-block; width: auto; max-width: min(100%, {{ $logoWidth }}px); max-height: {{ $logoHeight }}px; object-fit: contain; margin-bottom: .75rem">
    @endif
    @if ($title)
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0 0 .5rem; @if ($textColor) color: {{ $textColor }}; @endif">{{ $title }}</h1>
    @endif
    @if ($message)
        <p style="margin: 0; opacity: .85; @if ($textColor) color: {{ $textColor }}; @endif">{{ $message }}</p>
    @endif
</div>
