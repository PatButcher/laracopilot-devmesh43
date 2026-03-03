@extends('layouts.app')
@section('title', '429 - Too Many Requests')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #0F0F1A, #1A0A2E);">
    <div class="text-center">
        <div class="text-9xl font-bold mb-4" style="background: linear-gradient(135deg, #F59E0B, #EF4444); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">429</div>
        <h1 class="text-3xl font-bold text-white mb-4">Too Many Requests</h1>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">You're sending requests too quickly. Please slow down and try again in a few minutes.</p>
        <a href="/" class="px-6 py-3 rounded-full font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">← Go Home</a>
    </div>
</div>
@endsection
