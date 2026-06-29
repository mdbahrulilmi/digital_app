@php
    $fontFamily  = $component->content['font_family'] ?? 'font-sans';
    $fontSize    = $component->content['font_size'] ?? 'text-sm';
    $lineHeight  = $component->content['line_height'] ?? 'leading-relaxed';
    $alignment   = $component->content['alignment'] ?? 'text-left';
    
    $fontWeight  = (!empty($component->content['is_bold']) && $component->content['is_bold']) ? 'font-bold' : 'font-normal';
    $fontStyle   = (!empty($component->content['is_italic']) && $component->content['is_italic']) ? 'italic' : 'not-italic';
    $fontDecor   = (!empty($component->content['is_underline']) && $component->content['is_underline']) ? 'underline' : 'no-underline';
    
    $textColor   = $component->content['text_color'] ?? '#334155';
@endphp
<div 
    class="bg-white {{ $fontFamily }} {{ $fontSize }} {{ $lineHeight }} {{ $alignment }} {{ $fontWeight }} {{ $fontStyle }} {{ $fontDecor }}"
    style="color: {{ $textColor }};"
>
    @if(!empty($component->content['text']))
        {!! nl2br(e($component->content['text'])) !!}
    @else
        <p class="text-slate-300 italic text-center no-underline font-normal">Ketik konten teks...</p>
    @endif
</div>