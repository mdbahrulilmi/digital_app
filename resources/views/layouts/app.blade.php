<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

@php
$menus = [
    [
        'label' => 'Landing Page',
        'icon' => 'home',
        'url' => url('/admin/landing-page'),
    ],
    [
        'label' => 'Product',
        'icon' => 'box',
        'url' => url('/admin/product'),
    ],
    [
        'label' => 'Media',
        'icon' => 'image',
        'url' => url('/admin/media'),
    ],
    [
        'label' => 'Pengaturan',
        'icon' => 'settings',
        'url' => '#',
    ],
];

function icon($name) {
    return match($name) {
        'home' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>',
        'box' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25l-9-5-9 5 9 5 9-5Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25v7.5l9 5 9-5v-7.5"/></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0 1 15 0"/></svg>',
        'settings' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.767c-.307.235-.45.645-.404 1.03v.172c-.046.385.097.795.404 1.03l1.003.767a1.125 1.125 0 0 1 .26 1.43l-1.296 2.247a1.125 1.125 0 0 1-1.37.49l-1.216-.456c-.356-.133-.751-.072-1.076.124-.072.044-.146.087-.22.128-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.767c.304-.233.446-.639.404-1.02a3.483 3.483 0 0 1 0-.173c.042-.38-.1-.786-.404-1.02l-1.004-.767a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.49l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/></svg>',
        'image' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.25 2.25 0 0 1 5.25 5.25h13.5A2.25 2.25 0 0 1 21 7.5v9A2.25 2.25 0 0 1 18.75 18.75H5.25A2.25 2.25 0 0 1 3 16.5v-9Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5.25-5.25a1.5 1.5 0 0 0-2.12 0L6 17.25" />
        </svg>',
        default => '',
    };
}
@endphp

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 hidden md:flex">

        <div>

            {{-- LOGO --}}
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-600 rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-white">User Dashboard</span>
                </div>
            </div>

            {{-- MENU --}}
            <div class="px-4 py-6">
                <p class="text-xs font-semibold text-slate-500 uppercase px-3 mb-3">
                    Menu Utama
                </p>

                <nav class="space-y-1">
                    @foreach ($menus as $menu)
                        @php
                            $isActive = request()->url() === $menu['url'];
                        @endphp

                        <a href="{{ $menu['url'] }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all
                           {{ $isActive ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">

                            {!! icon($menu['icon']) !!}

                            <span>{{ $menu['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

        </div>

        {{-- USER --}}
        <div class="p-4 border-t border-slate-800 flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff"
                 class="w-9 h-9 rounded-full">

            <div>
                <p class="text-sm font-semibold text-white">User</p>
                <p class="text-xs text-slate-500">Super Admin</p>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col min-w-0">

        <main class="flex-1 p-6 overflow-y-auto">

            @if(isset($slot) && $slot->isNotEmpty())
                {{ $slot }}
            @else
                <h1 class="text-2xl font-bold">Ringkasan Analitik</h1>
            @endif

        </main>

    </div>

</div>

@livewireScripts
</body>
</html>