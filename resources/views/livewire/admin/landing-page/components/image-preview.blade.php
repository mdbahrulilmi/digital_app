<div class="text-center bg-white">
    @if(!empty($component->content['image_url']))
        <div class="inline-block w-full overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
            <div class="w-full aspect-square overflow-hidden bg-slate-100">
                <img
                    src="{{ $component->content['image_url'] }}"
                    alt="Preview"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
    @else
        <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-slate-400 text-xs bg-white flex flex-col items-center justify-center gap-1">
            <span>🖼️</span>
            <span class="text-[11px]">{{ $component->content['title'] ?? 'Placeholder Gambar' }}</span>
        </div>
    @endif
</div>