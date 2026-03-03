@extends('layouts.app')
@section('title', '403 - Access Denied')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #0F0F1A, #1A0A2E);">
    <div class="text-center">
        <div class="text-9xl font-bold mb-4" style="background: linear-gradient(135deg, #EF4444, #F97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">403</div>
        <h1 class="text-3xl font-bold text-white mb-4">Access Denied</h1>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">You don't have permission to access this page. If you believe this is an error, please contact support.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="px-6 py-3 rounded-full font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">← Go Home</a>
            <a href="/login" class="px-6 py-3 rounded-full font-semibold border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition">Sign In</a>
        </div>
    </div>
</div>
@endsection
