@extends('layouts.admin')
@section('title', 'Theme Editor')
@section('page-title', 'Theme & Color Editor')
@section('content')
<form action="{{ route('admin.theme.update') }}" method="POST">
    @csrf @method('PUT')
    <div class="space-y-6 max-w-4xl">
        <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            <h3 class="font-semibold text-white mb-5">🎨 Color Palette</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach([
                    ['key' => 'primary_color', 'label' => 'Primary Color', 'desc' => 'Buttons, links, highlights'],
                    ['key' => 'secondary_color', 'label' => 'Secondary Color', 'desc' => 'Gradients, accents'],
                    ['key' => 'accent_color', 'label' => 'Accent Color', 'desc' => 'Highlights, badges'],
                    ['key' => 'background_color', 'label' => 'Background', 'desc' => 'Main page background'],
                    ['key' => 'nav_bg_color', 'label' => 'Navigation BG', 'desc' => 'Top navigation bar'],
                    ['key' => 'footer_bg_color', 'label' => 'Footer BG', 'desc' => 'Page footer'],
                    ['key' => 'text_color', 'label' => 'Text Color', 'desc' => 'Main text color'],
                ] as $f)
                <div class="p-4 rounded-xl border border-white/10" style="background: rgba(0,0,0,0.2);">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="color" name="{{ $f['key'] }}" value="{{ $settings[$f['key']] ?? '#8B5CF6' }}" class="w-10 h-10 rounded-lg cursor-pointer border-0 flex-shrink-0" style="background: none;">
                        <div>
                            <div class="text-sm font-medium text-white">{{ $f['label'] }}</div>
                            <div class="text-xs text-gray-500">{{ $f['desc'] }}</div>
                        </div>
                    </div>
                    <div class="text-xs font-mono text-gray-400">{{ $settings[$f['key']] ?? '' }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            <h3 class="font-semibold text-white mb-5">🔤 Typography & Layout</h3>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Font Family</label>
                    <select name="font_family" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                        @foreach(['Inter', 'Roboto', 'Poppins', 'Montserrat', 'Open Sans', 'Raleway', 'DM Sans', 'Nunito'] as $font)
                        <option {{ ($settings['font_family'] ?? '') === $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Player Theme</label>
                    <select name="player_theme" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                        <option value="dark" {{ ($settings['player_theme'] ?? '') === 'dark' ? 'selected' : '' }}>Dark</option>
                        <option value="light" {{ ($settings['player_theme'] ?? '') === 'light' ? 'selected' : '' }}>Light</option>
                        <option value="gradient" {{ ($settings['player_theme'] ?? '') === 'gradient' ? 'selected' : '' }}>Gradient</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            <h3 class="font-semibold text-white mb-4">👁 Preview</h3>
            <div class="p-4 rounded-xl" style="background: {{ $settings['background_color'] ?? '#0F0F1A' }};">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-lg" style="background: linear-gradient(135deg, {{ $settings['primary_color'] ?? '#8B5CF6' }}, {{ $settings['secondary_color'] ?? '#EC4899' }});"></div>
                    <span style="color: {{ $settings['text_color'] ?? '#F9FAFB' }}; font-family: {{ $settings['font_family'] ?? 'Inter' }}, sans-serif;" class="font-bold">SoundWave</span>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1 rounded-full text-sm text-white" style="background: {{ $settings['primary_color'] ?? '#8B5CF6' }};">Play</span>
                    <span class="px-3 py-1 rounded-full text-sm" style="background: {{ $settings['accent_color'] ?? '#06B6D4' }}22; color: {{ $settings['accent_color'] ?? '#06B6D4' }};">Electronic</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Save Theme</button>
        </div>
    </div>
</form>
@endsection
