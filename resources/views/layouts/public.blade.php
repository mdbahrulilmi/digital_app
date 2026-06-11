<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->title ?? $title ?? '' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen antialiased flex justify-center items-start">
    <div class="w-full max-w-md min-h-screen bg-white shadow-xl flex flex-col justify-between relative border-x border-slate-200/50">
    
    @if(isset($landingPage) && $landingPage->cart)
        @livewire('public.components.cart-badge')
    @endif
    
    @if(isset($slot) && $slot->isNotEmpty())
        {{ $slot }}
    @endif

    @if(isset($landingPage) && $landingPage->cart)
        @livewire('public.components.cart-footer')
    @endif
    </div>
    
    <style>
        .rich-text-output ul { list-style-type: disc !important; padding-left: 20px !important; margin-bottom: 12px; }
        .rich-text-output ol { list-style-type: decimal !important; padding-left: 20px !important; margin-bottom: 12px; }
        .rich-text-output h1 { font-size: 1.4rem !important; font-weight: bold !important; margin-top: 14px; margin-bottom: 8px; color: #1e293b; }
        .rich-text-output h2 { font-size: 1.2rem !important; font-weight: bold !important; margin-top: 12px; margin-bottom: 6px; color: #1e293b; }
        .rich-text-output p { margin-bottom: 8px; }
        .rich-text-output strong { font-weight: 700; color: #0f172a; }
    </style>
</body>
</html>