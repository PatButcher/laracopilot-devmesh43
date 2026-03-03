<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SoundWave</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #0F0F1A; font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center text-white text-2xl font-bold mb-4" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">SW</div>
        <h1 class="text-3xl font-bold text-white">SoundWave Admin</h1>
        <p class="text-gray-400 mt-2">Sign in to manage your platform</p>
    </div>

    <!-- Demo Credentials -->
    <div class="mb-6 p-4 rounded-xl border border-purple-500/30" style="background: rgba(139,92,246,0.1);">
        <p class="text-sm font-semibold text-purple-300 mb-2">🔑 Demo Credentials:</p>
        <div class="space-y-1 text-xs text-gray-300">
            <div>📧 <strong>admin@soundwave.com</strong> / <strong>admin123</strong></div>
            <div>📧 <strong>manager@soundwave.com</strong> / <strong>manager123</strong></div>
            <div>📧 <strong>editor@soundwave.com</strong> / <strong>editor123</strong></div>
        </div>
    </div>

    <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/30 text-red-300 text-sm">{{ $errors->first() }}</div>
        @endif
        <form action="/admin/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition"
                    placeholder="admin@soundwave.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition"
                    placeholder="••••••••">
            </div>
            <button type="submit" class="w-full py-3 rounded-xl font-semibold text-white transition" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Sign In to Admin Panel</button>
        </form>
    </div>
    <p class="text-center mt-4 text-sm text-gray-500"><a href="/" class="text-purple-400 hover:underline">← Back to SoundWave</a></p>
</div>
</body>
</html>
