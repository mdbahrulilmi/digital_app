@if($showModal && $selectedProduct)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-bold text-slate-800">{{ $selectedProduct->title }}</h2>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
    
            <div class="space-y-4">
            @php
                $asset = $selectedProduct->decoded_asset;
                $path = $asset['path'] ?? '';
                $type = $asset['type'] ?? '';
                
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $fullUrl = Storage::url($path);
            @endphp

            @if($type === 'link')
                @if(str_contains($asset['url'] ?? '', 'youtube.com') || str_contains($asset['url'] ?? '', 'youtu.be'))
                    @php
                        $videoId = '';
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $asset['url'], $matches);
                        $videoId = $matches[1] ?? '';
                    @endphp
                    <div class="w-full aspect-video bg-black rounded-2xl overflow-hidden">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                    </div>
                @else
                    <img src="{{ $asset['url'] }}" class="w-full rounded-2xl shadow-sm" alt="Asset">
                @endif

            @elseif($path)
                
                @if($extension === 'pdf')
                    <div class="w-full h-[80vh] bg-slate-100 rounded-2xl overflow-hidden border border-slate-200">
                        <iframe src="{{ $fullUrl }}#toolbar=0&navpanes=0" class="w-full h-full"></iframe>
                    </div>

                @elseif(in_array($extension, ['mp4', 'mov', 'webm']))
                    <div class="w-full bg-black rounded-2xl overflow-hidden">
                        <video controls playsinline class="w-full h-auto max-h-[70vh]">
                            <source src="{{ $fullUrl }}" type="video/{{ $extension }}">
                            Browser lu gak support video.
                        </video>
                    </div>

                @elseif(in_array($extension, ['mp3', 'wav', 'ogg']))
                    <div class="p-8 bg-slate-900 rounded-2xl flex items-center justify-center">
                        <audio controls class="w-full">
                            <source src="{{ $fullUrl }}" type="audio/{{ $extension }}">
                        </audio>
                    </div>

                @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                    <img src="{{ $fullUrl }}" class="w-full rounded-2xl shadow-sm" alt="Asset">

                @else
                    <div class="p-8 bg-slate-100 rounded-2xl text-center">
                        <p>Format file tidak didukung: {{ $extension }}</p>
                    </div>
                @endif
            @endif
        </div>
        </div>
    </div>
    @endif
    @if(isset($showUploadModal) && $showUploadModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8">
                <h2 class="text-xl font-black text-slate-900 mb-2">Kumpul Tugas</h2>
                
                <form wire:submit.prevent="submitTask" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Pilih File</label>
                        <input type="file" wire:model="taskFile" 
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-2xl p-2 cursor-pointer">
                        
                        @error('taskFile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        
                        <div wire:loading wire:target="taskFile" class="text-[10px] text-indigo-600 font-bold animate-pulse">
                            Sedang menyiapkan file...
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="closeUploadModal" 
                            class="px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">
                            Batal
                        </button>
                        
                        <button type="submit" 
                            wire:loading.attr="disabled"
                            class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-2xl text-sm font-bold transition-all active:scale-95 disabled:opacity-50 flex items-center gap-2">
                            
                            <span wire:loading wire:target="submitTask" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                            
                            <span wire:loading.remove wire:target="submitTask">Kirim Tugas</span>
                            <span wire:loading wire:target="submitTask">Mengirim...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif