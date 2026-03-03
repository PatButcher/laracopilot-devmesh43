@extends('layouts.admin')
@section('title', 'Landing Page Builder')
@section('page-title', 'Landing Page Builder')
@section('content')
<form action="{{ route('admin.landing.update') }}" method="POST" class="max-w-4xl space-y-6">
    @csrf @method('PUT')
    <!-- Hero Section -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">🦸 Hero Section</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Hero Title</label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Hero Subtitle</label>
                <textarea name="hero_subtitle" rows="2" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500 resize-none" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Primary CTA Text</label>
                    <input type="text" name="hero_cta_text" value="{{ $settings['hero_cta_text'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Primary CTA URL</label>
                    <input type="text" name="hero_cta_url" value="{{ $settings['hero_cta_url'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Secondary CTA Text</label>
                    <input type="text" name="hero_secondary_cta_text" value="{{ $settings['hero_secondary_cta_text'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Secondary CTA URL</label>
                    <input type="text" name="hero_secondary_cta_url" value="{{ $settings['hero_secondary_cta_url'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Gradient From</label>
                    <div class="flex gap-2">
                        <input type="color" name="hero_bg_gradient_from" value="{{ $settings['hero_bg_gradient_from'] ?? '#0F0F1A' }}" class="w-12 h-10 rounded-lg cursor-pointer border-0">
                        <input type="text" value="{{ $settings['hero_bg_gradient_from'] ?? '' }}" class="flex-1 px-3 py-2 rounded-xl border text-white text-sm" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Gradient To</label>
                    <div class="flex gap-2">
                        <input type="color" name="hero_bg_gradient_to" value="{{ $settings['hero_bg_gradient_to'] ?? '#1A0A2E' }}" class="w-12 h-10 rounded-lg cursor-pointer border-0">
                        <input type="text" value="{{ $settings['hero_bg_gradient_to'] ?? '' }}" class="flex-1 px-3 py-2 rounded-xl border text-white text-sm" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">✨ Features Section</h3>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Section Title</label>
                <input type="text" name="features_title" value="{{ $settings['features_title'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Section Subtitle</label>
                <input type="text" name="features_subtitle" value="{{ $settings['features_subtitle'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
        </div>
        @foreach([1,2,3,4] as $i)
        <div class="p-4 rounded-xl border border-white/5 mb-3" style="background: rgba(0,0,0,0.2);">
            <div class="text-xs text-gray-400 mb-2 font-medium">Feature {{ $i }}</div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Icon (emoji)</label>
                    <input type="text" name="feature_{{ $i }}_icon" value="{{ $settings['feature_'.$i.'_icon'] ?? '🎵' }}" class="w-full px-3 py-2 rounded-lg border text-white text-sm focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Title</label>
                    <input type="text" name="feature_{{ $i }}_title" value="{{ $settings['feature_'.$i.'_title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-white text-sm focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Description</label>
                    <input type="text" name="feature_{{ $i }}_desc" value="{{ $settings['feature_'.$i.'_desc'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-white text-sm focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Sections Visibility -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">👁 Sections Visibility</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['key' => 'show_featured_tracks', 'label' => 'Featured Tracks'],
                ['key' => 'show_featured_artists', 'label' => 'Featured Artists'],
                ['key' => 'show_channels', 'label' => 'Channels'],
                ['key' => 'show_genres', 'label' => 'Genres'],
            ] as $toggle)
            <div class="flex items-center gap-2 p-3 rounded-xl" style="background: rgba(0,0,0,0.2);">
                <input type="checkbox" name="{{ $toggle['key'] }}" value="1" id="{{ $toggle['key'] }}" class="w-4 h-4 rounded" {{ ($settings[$toggle['key']] ?? '1') === '1' ? 'checked' : '' }}>
                <label for="{{ $toggle['key'] }}" class="text-sm text-gray-300 cursor-pointer">{{ $toggle['label'] }}</label>
            </div>
            @endforeach
        </div>
    </div>

    <!-- CTA Section -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">📣 Bottom CTA Section</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">CTA Title</label>
                <input type="text" name="cta_section_title" value="{{ $settings['cta_section_title'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">CTA Subtitle</label>
                <input type="text" name="cta_section_subtitle" value="{{ $settings['cta_section_subtitle'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-8 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Save Landing Page</button>
    </div>
</form>
@endsection
