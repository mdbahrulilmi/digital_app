@php
    // Membaca pengaturan class Tailwind CSS
    $fontFamily  = $section->content['font_family'] ?? 'font-sans';
    $fontSize    = $section->content['font_size'] ?? 'text-sm';
    $lineHeight  = $section->content['line_height'] ?? 'leading-relaxed';
    $alignment   = $section->content['alignment'] ?? 'text-left';
    
    // Mengecek toggle format teks
    $fontWeight  = (!empty($section->content['is_bold']) && $section->content['is_bold']) ? 'font-bold' : 'font-normal';
    $fontStyle   = (!empty($section->content['is_italic']) && $section->content['is_italic']) ? 'italic' : 'not-italic';
    $fontDecor   = (!empty($section->content['is_underline']) && $section->content['is_underline']) ? 'underline' : 'no-underline';
    
    // Membaca custom warna teks hex
    $textColor   = $section->content['text_color'] ?? '#334155';
@endphp

<div 
    class="px-6 py-6 bg-white {{ $fontFamily }} {{ $fontSize }} {{ $lineHeight }} {{ $alignment }} {{ $fontWeight }} {{ $fontStyle }} {{ $fontDecor }}"
    style="color: {{ $textColor }};"
>
    @if(!empty($section->content['text']))
        {!! nl2br(e($section->content['text'])) !!}
    @else
        <p class="text-slate-300 italic text-center no-underline font-normal">Ketik konten teks...</p>
    @endif
</div>