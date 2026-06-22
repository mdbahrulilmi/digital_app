<div class="space-y-3">
    <div>
        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Video</label>
        <input type="text" wire:model="editingContent.title" class="w-full text-sm p-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500">
    </div>

    <label class="block text-xs font-bold text-slate-600 uppercase">Sumber Konten Media</label>
    
    <div class="flex flex-col gap-2 w-full">
    <label class="text-sm font-semibold text-slate-700">
        🔗 URL Video
    </label>
    
    <input 
        type="url" 
        wire:model="editingContent.video_url" 
        class="w-full text-sm p-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
        placeholder="https://youtube.com/embed/... atau format .mp4"
    >
    
    <p class="text-xs text-slate-400">
        Masukkan link embed YouTube atau direct link file .mp4
    </p>
</div>

</div>