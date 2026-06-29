<div class="w-full py-2 px-4" style="text-align: {{ $component->content['alignment'] ?? 'center' }};">
    <a
        href="{{ $component->content['url'] ?? '#' }}"
        style="
            background: {{ $component->content['bg_color'] ?? '#4f46e5' }};
            color: {{ $component->content['text_color'] ?? '#fff' }};
            font-size: {{ $component->content['font_size'] ?? '14px' }};
            border-radius: {{ $component->content['radius'] ?? '8px' }};
            border: {{ $component->content['border_width'] ?? '0px' }} solid {{ $component->content['border_color'] ?? '#000' }};
            width: {{ ($component->content['full_width'] ?? false) ? '100%' : ($component->content['width'] ?? 'auto') }};
            height: {{ isset($component->content['height']) ? $component->content['height'].'px' : 'auto' }};
            padding: {{ $component->content['padding_y'] ?? 10 }}px {{ $component->content['padding_x'] ?? 20 }}px;
            display: {{ ($component->content['full_width'] ?? false) ? 'block' : 'inline-flex' }};
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 600;
            box-shadow: {{ ($component->content['shadow'] ?? true) ? '0 4px 10px rgba(0,0,0,.08)' : 'none' }};
        "
    >
        {{ $component->content['text'] ?? 'Tombol' }}
    </a>
</div>