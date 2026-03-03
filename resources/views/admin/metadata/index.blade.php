@extends('layouts.admin')
@section('title', 'Metadata Manager')
@section('page-title', 'Metadata & SEO Manager')
@section('content')
<form action="{{ route('admin.metadata.update') }}" method="POST" class="max-w-3xl space-y-6">
    @csrf @method('PUT')
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">🌐 Site Identity</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Site Name *</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'SoundWave' }}" required class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Tagline</label>
                <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" placeholder="Stream. Discover. Share." class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Favicon URL</label>
                <input type="text" name="favicon_url" value="{{ $settings['favicon_url'] ?? '' }}" placeholder="/favicon.ico" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
        </div>
    </div>

    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">🔍 SEO Metadata</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Meta Description</label>
                <textarea name="meta_description" rows="2" placeholder="Describe your site in 160 characters" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 resize-none" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ $settings['meta_description'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="music, streaming, artists" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
        </div>
    </div>

    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">📱 Open Graph (Social Sharing)</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">OG Title</label>
                <input type="text" name="og_title" value="{{ $settings['og_title'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">OG Description</label>
                <textarea name="og_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500 resize-none" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ $settings['og_description'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Twitter Handle</label>
                <input type="text" name="twitter_handle" value="{{ $settings['twitter_handle'] ?? '' }}" placeholder="@soundwave" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
        </div>
    </div>

    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">📊 Analytics</h3>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Google Analytics Measurement ID</label>
            <input type="text" name="google_analytics" value="{{ $settings['google_analytics'] ?? '' }}" placeholder="G-XXXXXXXXXX" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-8 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Save Metadata</button>
    </div>
</form>
@endsection
