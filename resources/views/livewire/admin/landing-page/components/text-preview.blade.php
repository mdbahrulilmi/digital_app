<div class="px-4 bg-white overflow-hidden">
    @if(!empty($section->content['text']))
        <div class="ql-editor p-0"> 
            {!! $section->content['text'] !!}
        </div>
    @else
        <p class="text-slate-300 italic text-center no-underline font-normal">Ketik konten teks...</p>
    @endif
</div>