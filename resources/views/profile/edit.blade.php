@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">✏️ Edit Profile</h1>
        <p class="text-gray-400 mt-1">Update your public profile information</p>
    </div>
    <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="/profile" method="POST" class="space-y-5">
            @csrf @method('PUT')
            @if($errors->any())
            <div class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm">
                @foreach($errors->all() as $e)<div>✗ {{ $e }}</div>@endforeach
            </div>
            @endif
            @if(session('success'))
            <div class="p-4 rounded-xl border border-green-500/30 bg-green-500/10 text-green-300 text-sm">✓ {{ session('success') }}</div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Display Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 rounded-xl text-white border transition focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Bio</label>
                <textarea name="bio" rows="3" placeholder="Tell the world about yourself..." class="w-full px-4 py-3 rounded-xl text-white border transition focus:outline-none focus:border-purple-500 resize-none" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('bio', $user->bio) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Website</label>
                <input type="url" name="website" value="{{ old('website', $user->website) }}" placeholder="https://yoursite.com" class="w-full px-4 py-3 rounded-xl text-white border transition focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="border-t border-white/10 pt-5">
                <h3 class="font-medium text-white mb-4">🔐 Change Password</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1.5">Current Password</label>
                        <input type="password" name="current_password" class="w-full px-4 py-3 rounded-xl text-white border transition focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1.5">New Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl text-white border transition focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl text-white border transition focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                    </div>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/profile" class="flex-1 text-center py-3 rounded-xl border border-white/20 text-gray-300 hover:text-white transition">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
