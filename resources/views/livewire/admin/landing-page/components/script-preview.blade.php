@if(!empty($component->content['script']))

    @php
        preg_match(
            '/<!--\s*height:(\d+)\s*-->/',
            $component->content['script'],
            $matches
        );

        $height = $matches[1] ?? 300;
        $rawScript = $component->content['script'] ?? '';
        $encodedScript = base64_encode($rawScript);
    @endphp

    @if(!empty($rawScript))
        <iframe
            src="data:text/html;base64,{{ $encodedScript }}"
            sandbox="allow-scripts allow-same-origin allow-popups allow-top-navigation allow-modals"
            scrolling="no"
            style="height: {{ $height }}px;"
            class="w-full border-0 bg-transparent block overflow-hidden">
        </iframe>
    @else
        <div class="text-center py-6 text-slate-400 text-xs italic">
            Belum ada script yang dibuat.
        </div>
    @endif
@endif