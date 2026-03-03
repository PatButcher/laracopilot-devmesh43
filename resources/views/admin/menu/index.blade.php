@extends('layouts.admin')
@section('title', 'Menu Manager')
@section('page-title', 'Menu Manager')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add Menu Item Form -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-5">+ Add Menu Item</h3>
        <form action="{{ route('admin.menu.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Label *</label>
                <input type="text" name="label" required placeholder="Discover" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">URL *</label>
                <input type="text" name="url" required placeholder="/discover" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Location</label>
                <select name="location" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                    <option value="header">Header</option>
                    <option value="footer">Footer</option>
                    <option value="sidebar">Sidebar</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Icon (emoji)</label>
                <input type="text" name="icon" placeholder="🎵" class="w-full px-4 py-2.5 rounded-xl border text-white placeholder-gray-500 focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="0" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Open In</label>
                <select name="target" class="w-full px-4 py-2.5 rounded-xl border text-white focus:outline-none focus:border-purple-500" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                    <option value="_self">Same Tab</option>
                    <option value="_blank">New Tab</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" class="w-4 h-4" checked>
                <label for="is_active" class="text-sm text-gray-300">Active</label>
            </div>
            <button type="submit" class="w-full py-2.5 rounded-xl font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Add Menu Item</button>
        </form>
    </div>

    <!-- Menu Items List -->
    <div class="lg:col-span-2 space-y-3">
        @foreach(['header', 'footer', 'sidebar'] as $location)
        @php $locationItems = $menuItems->where('location', $location); @endphp
        @if($locationItems->count())
        <div class="p-5 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            <h4 class="font-semibold text-white mb-3 capitalize">{{ $location }} Menu ({{ $locationItems->count() }} items)</h4>
            <div class="space-y-2">
                @foreach($locationItems->sortBy('sort_order') as $item)
                <div class="flex items-center gap-3 p-3 rounded-xl" style="background: rgba(0,0,0,0.2);">
                    @if($item->icon)<span>{{ $item->icon }}</span>@endif
                    <div class="flex-1">
                        <span class="font-medium text-white text-sm">{{ $item->label }}</span>
                        <span class="text-gray-500 text-xs ml-2">{{ $item->url }}</span>
                    </div>
                    <span class="text-xs {{ $item->is_active ? 'text-green-400' : 'text-gray-500' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                    <span class="text-xs text-gray-600">#{{ $item->sort_order }}</span>
                    <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-400 hover:text-red-300">✕</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
        @if($menuItems->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <p>No menu items yet. Add some using the form.</p>
        </div>
        @endif
    </div>
</div>
@endsection
