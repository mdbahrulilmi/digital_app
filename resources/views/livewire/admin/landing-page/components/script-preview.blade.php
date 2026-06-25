@if(!empty($section->content['script']))

    @php
        preg_match(
            '/<!--\s*height:(\d+)\s*-->/',
            $section->content['script'],
            $matches
        );

        $height = $matches[1] ?? 300;
    @endphp

    <iframe
        srcdoc='{!! $section->content["script"] !!}'
        sandbox="allow-scripts allow-popups allow-top-navigation allow-modals"
        scrolling="no"
        style="height: {{ $height }}px;"
        class="w-full border-0 bg-transparent block overflow-hidden">
    </iframe>

@else

    <div class="text-center py-6 text-slate-400 text-xs italic">
        Belum ada script yang dibuat.
    </div>

@endif