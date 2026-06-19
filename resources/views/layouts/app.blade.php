<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

@php

$menuGroups = [
    'Manajemen Utama' => [
        ['label' => 'Dashboard', 'icon' => 'home', 'url' => url('/admin')],
    ],

    'Management Konten' => [
        ['label' => 'Landing Page', 'icon' => 'layout', 'url' => url('/admin/landing-page')],
        ['label' => 'Program', 'icon' => 'book', 'url' => url('/admin/program')],
        ['label' => 'Produk Digital', 'icon' => 'box', 'url' => url('/admin/product')],
    ],

    'Transaksi' => [
        ['label' => 'Riwayat Transaksi', 'icon' => 'receipt', 'url' => url('/admin/orders')],
    ],

    'Member' => [
        ['label' => 'Data Member', 'icon' => 'users', 'url' => url('/admin/members')],
    ],

    'Lain-lain' => [
        ['label' => 'Media Library', 'icon' => 'image', 'url' => url('/admin/media')],
    ],

    'Akun' => [
        ['label' => 'Pengaturan', 'icon' => 'settings', 'url' => url('/admin/settings')],
    ],
];

function icon($name)
{
    return match ($name) {

        'home' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10h14V10"/>
        </svg>',

        'layout' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18"/>
        </svg>',

        'book' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>',

        'box' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
        </svg>',

        'receipt' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5h6m-6 4h6m-6 4h4M6 3h12v18l-2-1-2 1-2-1-2 1-2-1-2 1V3z"/>
        </svg>',

        'users' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-1a4 4 0 00-5.356-3.77M9 20H4v-1a4 4 0 015.356-3.77M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>',

        'image' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2"/>
            <circle cx="8" cy="10" r="1.5" stroke-width="2"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 15l-5-5-8 8"/>
        </svg>',

        'settings' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33
                1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51
                1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06
                a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09
                a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06
                a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9
                A1.65 1.65 0 0010 3.09V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51h.09
                a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06
                a1.65 1.65 0 00-.33 1.82V9c0 .66.39 1.26 1 1.51H21a2 2 0 010 4h-.09
                c-.66 0-1.26.39-1.51 1z"/>
        </svg>',

        default => '',
    };
}
@endphp

 <!-- SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col">

        <!-- Header -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800 flex-shrink-0">
            <span class="text-lg font-bold text-white">
                Admin Dashboard
            </span>
        </div>

        <!-- Menu -->
        <div class="flex-1 overflow-hidden px-4 py-5">
            @foreach ($menuGroups as $groupName => $items)

                <div class="mb-3">

                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-2">
                        {{ $groupName }}
                    </p>

                    <nav class="space-y-1">

                        @foreach ($items as $menu)

                            @php
                                $isActive = request()->url() === $menu['url'];
                            @endphp

                            <a href="{{ $menu['url'] }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                               {{ $isActive
                                    ? 'bg-indigo-600 text-white'
                                    : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">

                                {!! icon($menu['icon']) !!}
                                <span>{{ $menu['label'] }}</span>

                            </a>

                        @endforeach

                    </nav>

                </div>

            @endforeach
        </div>

        <!-- Logout -->
        <div class="p-4 border-t border-slate-800 flex-shrink-0">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="w-full py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- CONTENT -->
    <div class="h-screen overflow-y-auto" style="margin-left: 260px">
        <main class="p-6 min-w-0">
            {{ $slot ?? '' }}
        </main>
    </div>

@livewireScripts
</body>
</html>