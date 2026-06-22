    <div class="p-6 text-center bg-white space-y-2">
        @if(!empty($section->content['title']))
            <h4 class="text-xs font-bold text-slate-700 text-left">{{ $section->content['title'] }}</h4>
        @endif

        @if(!empty($section->content['video_url']))
            <div class="w-full aspect-video rounded-xl overflow-hidden bg-slate-900 shadow-sm">
                @php
            $url = $section->content['video_url'];
            
            // Fungsi sederhana untuk mendeteksi provider
            $isYoutube = str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be');
            $isVimeo = str_contains($url, 'vimeo.com');
        @endphp

        <div class="w-full aspect-video rounded-xl overflow-hidden bg-slate-900 shadow-sm">
            
            @if($isYoutube)
                @php
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $url, $matches);
                    $videoId = $matches[1] ?? null;
                @endphp
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>

           w --}}

            @else
                <video class="w-full h-full object-cover" controls>
                    <source src="{{ $url }}" type="video/mp4">
                    <source src="{{ $url }}" type="video/webm">
                    Browser Anda tidak mendukung tag video.
                </video>
            @endif
            </div>
        </div>
    @else
        <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-slate-400 text-xs bg-slate-50">
            🎥 URL Embed Video Belum Diisi
        </div>
    @endif
    </div>