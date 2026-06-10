<div class="space-y-3">
    <div>
        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama {{$currentType == 'image'     ? 'Gambar' : 'Video'}}</label>
        <input type="text" wire:model="editingContent.text" class="w-full text-sm p-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500">
    </div>

    <label class="block text-xs font-bold text-slate-600 uppercase">Sumber Konten Media</label>
    
    <div class="flex p-1 bg-slate-100 rounded-xl text-xs font-medium">
        <button type="button" wire:click="$set('mediaMethod', 'upload')" class="flex-1 py-2 rounded-lg transition-all {{ $mediaMethod === 'upload' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            📁 Upload Baru
        </button>
        <button type="button" wire:click="$set('mediaMethod', 'library')" class="flex-1 py-2 rounded-lg transition-all {{ $mediaMethod === 'library' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            📚 Dari Media
        </button>
        <button type="button" wire:click="$set('mediaMethod', 'url')" class="flex-1 py-2 rounded-lg transition-all {{ $mediaMethod === 'url' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            🔗 Paste URL
        </button>
    </div>

    @if($mediaMethod === 'upload')
        <div class="p-4 border border-slate-200 rounded-xl bg-slate-50/50 space-y-2">
            <input type="file" wire:model="newFile" accept="{{ $currentType === 'image' ? 'image/*' : 'video/mp4' }}" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <div wire:loading wire:target="newFile" class="text-[10px] text-amber-600 animate-pulse font-medium">⏳ Mengunggah berkas ke server...</div>
            
            @if ($newFile && $currentType === 'image')
                <div class="mt-2 text-center bg-white p-2 rounded-lg border border-slate-100 shadow-sm">
                    <img src="{{ $newFile->temporaryUrl() }}" class="max-h-24 mx-auto rounded">
                </div>
            @endif
        </div>
    @endif

    @if($mediaMethod === 'library')
        <div>
            <select wire:model.live="selectedMediaId" class="w-full text-sm p-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 bg-white">
                <option value="">-- Pilih item dari Gallery --</option>
                @foreach($mediaItems->where('type', $currentType === 'image' ? 'image' : 'video') as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>

            @if($selectedMediaId)
                @php $itemPreview = $mediaItems->firstWhere('id', $selectedMediaId); @endphp
                @if($itemPreview && $currentType === 'image')
                    <div class="mt-2 text-center bg-white p-2 rounded-lg border border-slate-100 shadow-sm">
                        <img src="{{ asset($itemPreview->file) }}" class="max-h-24 mx-auto rounded">
                    </div>
                @endif
            @endif
        </div>
    @endif

    @if($mediaMethod === 'url')
        <div>
            @if($currentType === 'image')
                <input type="text" wire:model="editingContent.image_url" class="w-full text-sm p-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500" placeholder="https://domain.com/path-to-image.jpg">
            @else
                <input type="url" wire:model="editingContent.video_url" class="w-full text-sm p-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500" placeholder="https://youtube.com/embed/... atau format .mp4 direct">
            @endif
        </div>
    @endif

</div>