@extends('layouts.app')
@section('title', 'Create Account')
@section('content')
<div class="min-h-screen flex items-center justify-center py-16 px-4" style="background: linear-gradient(135deg, #0F0F1A, #1A0A2E);">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">SW</div>
                <span class="font-bold text-xl text-white">SoundWave</span>
            </a>
            <h1 class="text-3xl font-bold text-white">Join SoundWave</h1>
            <p class="text-gray-400 mt-2">Create your free account and start streaming</p>
        </div>
        <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            @if($errors->any())
            <div class="mb-4 p-3 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm space-y-1">
                @foreach($errors->all() as $error)<div>✗ {{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="/register" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="Your name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="yourusername">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="you@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="Min. 8 characters">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="Repeat password">
                </div>
                <button type="submit" class="w-full py-3 rounded-xl font-semibold text-white mt-2 transition-transform hover:scale-[1.01]" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Create Account</button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">Already have an account? <a href="/login" class="text-purple-400 hover:text-purple-300 font-medium">Sign in →</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
