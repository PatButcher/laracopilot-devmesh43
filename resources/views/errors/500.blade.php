@extends('layouts.app')
@section('title', '500 - Server Error')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #0F0F1A, #1A0A2E);">
    <div class="text-center">
        <div class="text-9xl font-bold mb-4" style="background: linear-gradient(135deg, #EF4444, #F97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">500</div>
        <h1 class="text-3xl font-bold text-white mb-4">Something Went Wrong</h1>
        <p class="text-gray-400 mb-8 max-w-md">The server hit a wrong note. Our team is working to fix this. Please try again in a moment.</p>
        <a href="/" class="px-6 py-3 rounded-full font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">← Go Home</a>
    </div>
</div>
@endsection
