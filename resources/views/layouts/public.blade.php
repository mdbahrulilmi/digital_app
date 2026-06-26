<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $landingPage->meta_title ?: ($landingPage->title ?? $title ?? config('app.name')) }}
    </title>

    <meta name="description"
          content="{{ $landingPage->meta_description ?: ($landingPage->description ?? '') }}">

    <meta name="robots"
          content="{{ $landingPage->robots ?? 'index,follow' }}">

    @if(!empty($landingPage->canonical_url))
        <link rel="canonical" href="{{ $landingPage->canonical_url }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:title"
          content="{{ $landingPage->meta_title ?: ($landingPage->title ?? '') }}">
    <meta property="og:description"
          content="{{ $landingPage->meta_description ?: ($landingPage->description ?? '') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    @if(!empty($landingPage->image_url))
        <meta property="og:image"
              content="{{ Str::startsWith($landingPage->image_url, ['http://','https://']) ? $landingPage->image_url : asset($landingPage->image_url) }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
          content="{{ $landingPage->meta_title ?: ($landingPage->title ?? '') }}">
    <meta name="twitter:description"
          content="{{ $landingPage->meta_description ?: ($landingPage->description ?? '') }}">

    @if(!empty($landingPage->image_url))
        <meta name="twitter:image"
              content="{{ Str::startsWith($landingPage->image_url, ['http://','https://']) ? $landingPage->image_url : asset($landingPage->image_url) }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
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