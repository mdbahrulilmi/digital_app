@if(!empty($section->content['script']))
        <iframe 
            srcdoc='{!! $section->content['script'] !!}' 
            sandbox="allow-scripts allow-popups allow-top-navigation allow-modals"
            scrolling="no" 
            class="w-full h-[180px] border-0 bg-transparent block overflow-hidden">
        </iframe>
@else   
    <div class="text-center py-6 text-slate-400 text-xs italic">
        Belum ada tombol kustom yang dibuat.
    </div>
@endif