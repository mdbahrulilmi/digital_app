@php
    $asset = $product->decoded_asset ?? null;
@endphp

@if($asset)

    @php
        $type = $asset['type'] ?? '';
        $path = $asset['path'] ?? '';
        $url = $type === 'link'
            ? ($asset['url'] ?? '')
            : asset('storage/' . $path);

        $extension = strtolower(
            pathinfo($path, PATHINFO_EXTENSION)
        );
    @endphp

    <div class="w-full">

        {{-- LINK --}}
        @if($type === 'link')

            @if(str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be'))

                @php
                    preg_match(
                        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/',
                        $url,
                        $matches
                    );

                    $videoId = $matches[1] ?? '';
                @endphp

                <div class="rounded-2xl overflow-hidden bg-black shadow-lg">
                    <iframe
                        class="w-full aspect-video"
                        src="https://www.youtube.com/embed/{{ $videoId }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
                        allowfullscreen>
                    </iframe>
                </div>

            @else

                <div class="rounded-2xl overflow-hidden shadow-lg">
                    <img
                        src="{{ $url }}"
                        class="w-full h-auto object-contain"
                        alt="Asset">
                </div>

            @endif

        {{-- PDF --}}
        @elseif($extension === 'pdf')

            <div class="w-full h-[80vh] bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

                <iframe
                    src="{{ $url }}#toolbar=0&navpanes=0"
                    class="w-full h-full"
                    frameborder="0">
                </iframe>

            </div>

        {{-- OFFICE --}}
        @elseif(in_array($extension,['doc','docx','xls','xlsx','ppt','pptx']))

            <div class="w-full h-[80vh] bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

                <iframe
                    src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($url) }}"
                    class="w-full h-full"
                    frameborder="0">
                </iframe>

            </div>

        {{-- IMAGE --}}
        @elseif(in_array($extension,['jpg','jpeg','png','webp']))

            <div class="rounded-2xl overflow-hidden shadow-lg">

                <img
                    src="{{ $url }}"
                    class="w-full h-auto object-contain"
                    alt="Image">

            </div>

        {{-- VIDEO --}}
        @elseif(in_array($extension,['mp4','mov','webm']))

            <div class="rounded-2xl overflow-hidden bg-black shadow-lg">

                <video
                    controls
                    playsinline
                    preload="metadata"
                    class="w-full aspect-video object-contain bg-black">

                    <source
                        src="{{ $url }}"
                        type="video/{{ $extension }}">

                    Browser Anda tidak mendukung video.

                </video>

            </div>

        {{-- AUDIO --}}
        @elseif(in_array($extension,['mp3','wav','ogg']))

            <div class="p-8 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg">

                <audio controls class="w-full max-w-md">

                    <source
                        src="{{ $url }}"
                        type="audio/{{ $extension }}">

                </audio>

            </div>

        {{-- UNSUPPORTED --}}
        @else

            <div class="rounded-2xl border border-slate-200 bg-slate-50 py-16 px-6 text-center">

                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6M9 8h6"/>

                </svg>

                <p class="font-semibold text-slate-700">
                    Format file tidak didukung
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    .{{ $extension }}
                </p>

            </div>

        @endif

    </div>

@else

    <div class="p-8 bg-slate-100 rounded-2xl text-center text-slate-500">
        Asset atau media tidak tersedia untuk produk ini.
    </div>

@endif