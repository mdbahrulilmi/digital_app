<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

@php
$currentSlug = request()->route('slug');

$menuGroups = [
    'Menu Utama' => [
        ['label' => 'Hari Ini', 'icon' => 'home', 'url' => route('member.program.hari-ini', ['slug' => $currentSlug])],
        ['label' => 'Jurnal', 'icon' => 'box', 'url' => route('member.program.jurnal', ['slug' => $currentSlug])],
        ['label' => 'Webinar', 'icon' => 'image', 'url' => route('member.program.webinar', ['slug' => $currentSlug])],
        ['label' => 'Materi', 'icon' => 'users', 'url' => route('member.program.materi', ['slug' => $currentSlug])],
    ]
];
function icon($name) {
    return match ($name) {
        'home' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10h5v-6h6v6h5V10"/></svg>',
        'box' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a4 4 0 00-5.356-3.77M9 20H4v-1a4 4 0 015.356-3.77M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'settings' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 100-6 3 3 0 000 6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9A1.65 1.65 0 0010 3.09V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51h.09a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9c0 .66.39 1.26 1 1.51H21a2 2 0 010 4h-.09c-.66 0-1.26.39-1.51 1z"/></svg>',
        'image' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4 4 4 4-4 4 4M4 20h16"/></svg>',
        default => '',
    };
}
@endphp

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak></div>

    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col transform transition-transform duration-300 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <span class="text-lg font-bold text-white">Program Dashboard</span>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6">
            @foreach ($menuGroups as $groupName => $items)
                <div class="mb-8">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-2">{{ $groupName }}</p>
                    <nav class="space-y-1">
                        @foreach ($items as $menu)
                            @php $isActive = request()->url() === $menu['url']; @endphp
                            <a href="{{ $menu['url'] }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ $isActive ? 'bg-white-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                                {!! icon($menu['icon']) !!}
                                <span>{{ $menu['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            @endforeach
        </div>

        <div class="p-4 border-t border-slate-800">
            <a
                href="{{ route('member.dashboard') }}"
                class="block w-full py-2.5 rounded-xl bg-white hover:bg-slate-100 text-center text-slate-900 font-semibold transition border border-slate-200"
            >
                Kembali ke Dashboard
            </a>
        </div>
    </aside>

    <div class="lg:ml-64 min-h-screen transition-all">
        <div class="lg:hidden h-16 bg-white border-b flex items-center justify-end px-4">
            <button @click="sidebarOpen = true" class="p-2 text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <main class="p-6">
            {{ $slot ?? '' }}
        </main>
    </div>

@livewireScripts
</body>
</html>