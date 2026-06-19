<div class="p-6 text-center bg-white space-y-2">
    @if(!empty($section->content['title']))
        <h4 class="text-xs font-bold text-slate-700 text-left">{{ $section->content['title'] }}</h4>
    @endif
    @if(!empty($section->content['video_url']))
        <div class="w-full aspect-video rounded-xl overflow-hidden bg-slate-900 flex items-center justify-center shadow-sm">
            <span class="text-xs text-slate-400 font-medium">📺 Video Player Preview</span>
        </div>
    @else
        <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-slate-400 text-xs bg-slate-50">
            🎥 URL Embed Video Belum Diisi
        </div>
    @endif
</div>