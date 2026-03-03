@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="min-h-screen flex items-center justify-center py-16 px-4" style="background: linear-gradient(135deg, #0F0F1A, #1A0A2E);">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">SW</div>
                <span class="font-bold text-xl text-white">SoundWave</span>
            </a>
            <h1 class="text-3xl font-bold text-white">Welcome back</h1>
            <p class="text-gray-400 mt-2">Sign in to your account to continue</p>
        </div>
        <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            @if($errors->any())
            <div class="mb-4 p-3 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm">{{ $errors->first() }}</div>
            @endif
            @if(session('info'))
            <div class="mb-4 p-3 rounded-xl border border-blue-500/30 bg-blue-500/10 text-blue-300 text-sm">{{ session('info') }}</div>
            @endif
            <form action="/login" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="you@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                        style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" placeholder="••••••••">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded">
                        <span class="text-sm text-gray-400">Remember me</span>
                    </label>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl font-semibold text-white transition-transform hover:scale-[1.01]" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Sign In</button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">Don't have an account? <a href="/register" class="text-purple-400 hover:text-purple-300 font-medium">Create one free →</a></p>
            </div>
        </div>

        <!-- Demo credentials -->
        <div class="mt-4 p-4 rounded-xl border border-white/10 text-center" style="background: rgba(255,255,255,0.03);">
            <p class="text-xs text-gray-500 mb-1">Demo user: <span class="text-gray-300">alex@example.com</span> / <span class="text-gray-300">password123</span></p>
        </div>
    </div>
</div>
@endsection
