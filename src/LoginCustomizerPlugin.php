<?php

namespace LoginCustomizer;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use App\Contracts\Plugins\HasPluginSettings;
use App\Traits\EnvironmentWriterTrait;

class LoginCustomizerPlugin implements Plugin, HasPluginSettings
{
    use EnvironmentWriterTrait;

    public function getId(): string
    {
        return 'logincustomizer';
    }

    public function getSettingsFormData(): array
    {
        return config('logincustomizer', []);
    }

    public function getSettingsForm(): array
    {
        return [
            Toggle::make('reset_to_defaults')
                ->label('Reset all settings to defaults')
                ->helperText('Turn this on and save to clear all Login Customizer settings.'),
            Toggle::make('override_themes')
                ->label('Override dark and light themes')
                ->helperText('Apply the configured login colors in both theme modes.')
                ->default(fn () => config('logincustomizer.override_themes', false)),
            TextInput::make('title')
                ->label('Welcome heading')
                ->default(fn () => config('logincustomizer.title'))
                ->maxLength(80),
            Textarea::make('message')
                ->label('Welcome message')
                ->default(fn () => config('logincustomizer.message'))
                ->rows(3)
                ->maxLength(500),
            TextInput::make('logo_url')
                ->label('Logo URL')
                ->default(fn () => config('logincustomizer.logo_url'))
                ->url()
                ->helperText('Use an HTTPS URL. Leave blank to keep the default Pelican branding.'),
            TextInput::make('logo_width')
                ->label('Logo maximum width (pixels)')
                ->numeric()
                ->minValue(40)
                ->maxValue(1200)
                ->default(fn () => config('logincustomizer.logo_width')),
            TextInput::make('logo_height')
                ->label('Logo maximum height (pixels)')
                ->numeric()
                ->minValue(20)
                ->maxValue(600)
                ->default(fn () => config('logincustomizer.logo_height')),
            TextInput::make('background_url')
                ->label('Background media URL')
                ->default(fn () => config('logincustomizer.background_url'))
                ->url()
                ->helperText('Use an HTTPS URL. GIF backgrounds animate; MP4 URLs can play as looping video backgrounds.'),
            Select::make('background_type')
                ->label('Background media type')
                ->options(['auto' => 'Automatic', 'image' => 'Image or GIF', 'video' => 'Video'])
                ->default(fn () => config('logincustomizer.background_type', 'auto'))
                ->helperText('Automatic detects MP4, WebM, and OGG from the URL. Choose Video for URLs without a file extension.'),
            ColorPicker::make('page_color')
                ->label('Page background color')
                ->default(fn () => config('logincustomizer.page_color')),
            ColorPicker::make('card_color')
                ->label('Login card color')
                ->default(fn () => config('logincustomizer.card_color')),
            TextInput::make('card_opacity')
                ->label('Login card opacity (0–100)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->default(fn () => config('logincustomizer.card_opacity')),
            TextInput::make('card_radius')
                ->label('Login card corner radius (pixels)')
                ->numeric()
                ->minValue(0)
                ->maxValue(64)
                ->default(fn () => config('logincustomizer.card_radius')),
            TextInput::make('card_width')
                ->label('Login card maximum width (pixels)')
                ->numeric()
                ->minValue(280)
                ->maxValue(1000)
                ->default(fn () => config('logincustomizer.card_width')),
            Select::make('alignment')
                ->label('Branding alignment')
                ->options(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'])
                ->default(fn () => config('logincustomizer.alignment', 'center')),
            TextInput::make('font_family')
                ->label('Font family')
                ->maxLength(120)
                ->default(fn () => config('logincustomizer.font_family'))
                ->helperText('Example: Inter, sans-serif. The font must be available to visitors.'),
            ColorPicker::make('text_color')
                ->label('Text color')
                ->default(fn () => config('logincustomizer.text_color')),
            ColorPicker::make('accent_color')
                ->label('Accent color')
                ->default(fn () => config('logincustomizer.accent_color')),
            ColorPicker::make('button_text_color')
                ->label('Button text color')
                ->default(fn () => config('logincustomizer.button_text_color')),
            ColorPicker::make('link_color')
                ->label('Link color')
                ->default(fn () => config('logincustomizer.link_color')),
            TextInput::make('footer_text')
                ->label('Footer text')
                ->maxLength(200)
                ->default(fn () => config('logincustomizer.footer_text')),
            Textarea::make('custom_css')
                ->label('Additional CSS')
                ->rows(8)
                ->maxLength(12000)
                ->default(fn () => config('logincustomizer.custom_css'))
                ->helperText('Advanced: CSS injected on the login page. Only administrators should be allowed to edit this.'),
        ];
    }

    public function saveSettings(array $data): void
    {
        if (filter_var($data['reset_to_defaults'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            $this->writeToEnvironment([
                'LOGIN_CUSTOMIZER_OVERRIDE_THEMES' => 'false',
                'LOGIN_CUSTOMIZER_TITLE' => '',
                'LOGIN_CUSTOMIZER_MESSAGE' => '',
                'LOGIN_CUSTOMIZER_LOGO_URL' => '',
                'LOGIN_CUSTOMIZER_LOGO_WIDTH' => '',
                'LOGIN_CUSTOMIZER_LOGO_HEIGHT' => '',
                'LOGIN_CUSTOMIZER_BACKGROUND_URL' => '',
                'LOGIN_CUSTOMIZER_BACKGROUND_TYPE' => 'auto',
                'LOGIN_CUSTOMIZER_PAGE_COLOR' => '',
                'LOGIN_CUSTOMIZER_CARD_COLOR' => '',
                'LOGIN_CUSTOMIZER_CARD_OPACITY' => '',
                'LOGIN_CUSTOMIZER_CARD_RADIUS' => '',
                'LOGIN_CUSTOMIZER_CARD_WIDTH' => '',
                'LOGIN_CUSTOMIZER_ALIGNMENT' => 'center',
                'LOGIN_CUSTOMIZER_FONT_FAMILY' => '',
                'LOGIN_CUSTOMIZER_TEXT_COLOR' => '',
                'LOGIN_CUSTOMIZER_ACCENT_COLOR' => '',
                'LOGIN_CUSTOMIZER_BUTTON_TEXT_COLOR' => '',
                'LOGIN_CUSTOMIZER_LINK_COLOR' => '',
                'LOGIN_CUSTOMIZER_FOOTER_TEXT' => '',
                'LOGIN_CUSTOMIZER_CUSTOM_CSS' => '',
            ]);

            return;
        }

        $this->writeToEnvironment([
            'LOGIN_CUSTOMIZER_OVERRIDE_THEMES' => ($data['override_themes'] ?? false) ? 'true' : 'false',
            'LOGIN_CUSTOMIZER_TITLE' => $data['title'] ?? '',
            'LOGIN_CUSTOMIZER_MESSAGE' => $data['message'] ?? '',
            'LOGIN_CUSTOMIZER_LOGO_URL' => $data['logo_url'] ?? '',
            'LOGIN_CUSTOMIZER_LOGO_WIDTH' => $data['logo_width'] ?? '',
            'LOGIN_CUSTOMIZER_LOGO_HEIGHT' => $data['logo_height'] ?? '',
            'LOGIN_CUSTOMIZER_BACKGROUND_URL' => $data['background_url'] ?? '',
            'LOGIN_CUSTOMIZER_BACKGROUND_TYPE' => $data['background_type'] ?? 'auto',
            'LOGIN_CUSTOMIZER_PAGE_COLOR' => $data['page_color'] ?? '',
            'LOGIN_CUSTOMIZER_CARD_COLOR' => $data['card_color'] ?? '',
            'LOGIN_CUSTOMIZER_CARD_OPACITY' => $data['card_opacity'] ?? '',
            'LOGIN_CUSTOMIZER_CARD_RADIUS' => $data['card_radius'] ?? '',
            'LOGIN_CUSTOMIZER_CARD_WIDTH' => $data['card_width'] ?? '',
            'LOGIN_CUSTOMIZER_ALIGNMENT' => $data['alignment'] ?? 'center',
            'LOGIN_CUSTOMIZER_FONT_FAMILY' => $data['font_family'] ?? '',
            'LOGIN_CUSTOMIZER_TEXT_COLOR' => $data['text_color'] ?? '',
            'LOGIN_CUSTOMIZER_ACCENT_COLOR' => $data['accent_color'] ?? '',
            'LOGIN_CUSTOMIZER_BUTTON_TEXT_COLOR' => $data['button_text_color'] ?? '',
            'LOGIN_CUSTOMIZER_LINK_COLOR' => $data['link_color'] ?? '',
            'LOGIN_CUSTOMIZER_FOOTER_TEXT' => $data['footer_text'] ?? '',
            'LOGIN_CUSTOMIZER_CUSTOM_CSS' => $data['custom_css'] ?? '',
        ]);
    }

    public function register(Panel $panel): void
    {
        $panel->renderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
            fn (): string => view('logincustomizer::branding', [
                'settings' => config('logincustomizer', []),
            ])->render(),
        );

        $panel->renderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn (): string => view('logincustomizer::footer', [
                'settings' => config('logincustomizer', []),
            ])->render(),
        );
    }

    public function boot(Panel $panel): void
    {
    }
}
