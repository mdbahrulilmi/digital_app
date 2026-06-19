@if($isPreview)
<div class="w-full py-2 px-4" style="text-align: {{ $section->content['alignment'] ?? 'center' }};">
    <a href="javascript:void(0)"
        style="
            background: {{ $section->content['bg_color'] ?? '#4f46e5' }};
            color: {{ $section->content['text_color'] ?? '#fff' }};
            font-size: {{ $section->content['font_size'] ?? '14px' }};
            border-radius: {{ $section->content['radius'] ?? '8px' }};
            border: {{ $section->content['border_width'] ?? '0px' }} solid {{ $section->content['border_color'] ?? '#000' }};
            width: {{ ($section->content['full_width'] ?? false) ? '100%' : ($section->content['width'] ?? 'auto') }};
            height: {{ isset($section->content['height']) ? $section->content['height'].'px' : 'auto' }};
            padding: {{ $section->content['padding_y'] ?? 10 }}px {{ $section->content['padding_x'] ?? 20 }}px;
            display: {{ ($section->content['full_width'] ?? false) ? 'block' : 'inline-flex' }};
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 600;
            box-shadow: {{ ($section->content['shadow'] ?? true) ? '0 4px 10px rgba(0,0,0,.08)' : 'none' }};
            cursor:pointer;
        "
    >
        {{ $section->content['text'] ?? 'Tombol' }}
    </a>
</div>
@else
<div class="w-full py-2 px-4" style="text-align: {{ $section->content['alignment'] ?? 'center' }};">
    <a wire:click="addToCart('{{ $landingPage->program_id }}', '{{ addslashes($landingPage->program_id) }}', {{ $landingPage->program->price }}, 'checkout_program')"
        style="
            background: {{ $section->content['bg_color'] ?? '#4f46e5' }};
            color: {{ $section->content['text_color'] ?? '#fff' }};
            font-size: {{ $section->content['font_size'] ?? '14px' }};
            border-radius: {{ $section->content['radius'] ?? '8px' }};
            border: {{ $section->content['border_width'] ?? '0px' }} solid {{ $section->content['border_color'] ?? '#000' }};
            width: {{ ($section->content['full_width'] ?? false) ? '100%' : ($section->content['width'] ?? 'auto') }};
            height: {{ isset($section->content['height']) ? $section->content['height'].'px' : 'auto' }};
            padding: {{ $section->content['padding_y'] ?? 10 }}px {{ $section->content['padding_x'] ?? 20 }}px;
            display: {{ ($section->content['full_width'] ?? false) ? 'block' : 'inline-flex' }};
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 600;
            box-shadow: {{ ($section->content['shadow'] ?? true) ? '0 4px 10px rgba(0,0,0,.08)' : 'none' }};
            cursor:pointer;
        "
    >
        {{ $section->content['text'] ?? 'Tombol' }}
    </a>
</div>
@endif