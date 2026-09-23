<?php

/**
 * Native UI — Theme Tokens
 *
 * Published via `php artisan vendor:publish --tag=native-ui-config`.
 * Edit to customize your app's visual identity in one place.
 *
 * For dynamic per-tenant theming, use Nativephp\NativeUi\Theme::merge([...])
 * from a service provider. Runtime merges deep-merge on top of these values.
 *
 * Decision log: /docs/NATIVE-UI-REWRITE-PLAN.md (D — theme layer)
 */

return [

    /*
    |---------------------------------------------------------------------------
    | Theme
    |---------------------------------------------------------------------------
    |
    | 17 color tokens, 4 radii, 4 font sizes, font family.
    |
    | "on-X" means "color of content placed ON a surface of color X"
    |   — i.e., text/icons on that background.
    |
    | Color tokens accept:
    |   - CSS hex: '#B91C1C', '#F00', or with alpha '#8B5CF680' (#RRGGBBAA)
    |   - Tailwind palette names: 'red-300', 'orange-800'
    |   - Opacity modifiers on either: 'red-300/20', '#8B5CF6/50'
    |
    | Dark mode is auto-derived from `light` when `dark` is not set. To opt
    | into explicit dark tokens, fill out the `dark` block.
    |
    | The default pairs meet WCAG AA (4.5:1) — if you customize, keep each
    | `on-*` color at 4.5:1 contrast against its background token.
    |
    */

    'theme' => [

        'light' => [
            // Primary brand color — Sentinela / Centro Paula Souza / FATEC vinho
            'primary' => '#8B0024',
            'on-primary' => '#FFFFFF',
            'primary-dark' => '#66001A',
            'primary-light' => '#FCEBEF',

            // Secondary / teal action (Capturar Placa card)
            'secondary' => '#0F766E',
            'on-secondary' => '#FFFFFF',
            'teal' => '#0F766E',
            'on-teal' => '#FFFFFF',

            // Surface = cards, sheets, dialogs. Background = page root.
            'surface' => '#FFFFFF',
            'on-surface' => '#1C1917',
            'background' => '#F8F6F7',
            'on-background' => '#1C1917',

            // Surface variant = filled text fields, muted tonal surfaces.
            'surface-variant' => '#F3F4F6',
            'on-surface-variant' => '#6B7280',

            // Outline = neutral borders (text fields, dividers, cards).
            'outline' => '#E5E7EB',
            'outline-variant' => '#F1EFF0',

            // Status colors
            'destructive' => '#DC2626',
            'on-destructive' => '#FFFFFF',
            'success' => '#16A34A',
            'on-success' => '#FFFFFF',
            'warning' => '#D97706',
            'on-warning' => '#FFFFFF',

            // Accent
            'accent' => '#D97706',
            'on-accent' => '#FFFFFF',
            'plate-blue' => '#003399',
        ],

        'dark' => [
            'primary' => '#A51D38',
            'on-primary' => '#FFFFFF',
            'primary-dark' => '#8B0024',
            'primary-light' => '#3D0010',

            'secondary' => '#14B8A6',
            'on-secondary' => '#0F172A',
            'teal' => '#14B8A6',
            'on-teal' => '#0F172A',

            'surface' => '#18191D',
            'on-surface' => '#F3F4F6',
            'background' => '#0E0F12',
            'on-background' => '#F3F4F6',

            'surface-variant' => '#23252A',
            'on-surface-variant' => '#9CA3AF',

            'outline' => '#374151',
            'outline-variant' => '#2D3036',

            'destructive' => '#EF4444',
            'on-destructive' => '#0F172A',
            'success' => '#22C55E',
            'on-success' => '#0F172A',
            'warning' => '#F59E0B',
            'on-warning' => '#0F172A',

            'accent' => '#F59E0B',
            'on-accent' => '#0F172A',
            'plate-blue' => '#1D4ED8',
        ],

        // Corner radii (points / dp).
        'radius-sm' => 4,
        'radius-md' => 8,
        'radius-lg' => 16,
        'radius-full' => 9999,

        // Font size scale (points / sp).
        'font-sm' => 14,
        'font-md' => 16,
        'font-lg' => 20,
        'font-xl' => 24,
    ],

    'fonts' => [
        'default' => 'System',
        'accent' => 'Archivo+Black-Regular',
        'lobster' => 'Lobster+Two-Regular',
    ],

];
