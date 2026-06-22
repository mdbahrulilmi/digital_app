<div class="min-h-screen bg-slate-50 p-6 font-sans">

    {{-- Materi Hari Ini --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-4 overflow-hidden">
        <div class="px-5 pt-5 pb-3 border-b border-slate-100">
            <h5 class="text-sm font-semibold text-slate-500 uppercase tracking-widest">Materi Hari Ini</h5>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach($schedules as $item)
                <div class="flex items-center justify-between px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-blue-400 flex-shrink-0"></span>
                        <span class="text-sm text-slate-700">{{ $item->product->title }}</span>
                    </div>
                    <button 
                        wire:click="openProduct({{ $item->product_id }})" 
                        class="text-xs font-medium text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition-colors">
                        Lihat →
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tugas --}}
    @foreach($schedules as $item)
        <div class="card p-6 bg-white rounded-2xl shadow-sm mb-4">
            <h3 class="font-bold text-lg">{{ $item->product->name }}</h3>
            
            @if($item->tasks->count() > 0)
                <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                    <h4 class="text-sm font-bold text-indigo-900 uppercase">Tugas Hari Ini:</h4>
                    @foreach($item->tasks as $task)
                        <p class="text-sm text-indigo-700 mt-1">{{ $task->title }}</p>
                        
                        <button wire:click="openUploadModal({{ $task->id }})" 
                                class="mt-2 text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg">
                            Kumpul Tugas
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 mt-4 italic">Tidak ada tugas untuk materi ini.</p>
            @endif
        </div>
    @endforeach

    {{-- Journal --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-5 pt-5 pb-3 border-b border-slate-100">
            <h5 class="text-sm font-semibold text-slate-500 uppercase tracking-widest">Jurnal</h5>
        </div>
        <div class="p-5">
            <textarea
                class="w-full text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:border-transparent placeholder:text-slate-400 transition"
                rows="4"
                placeholder="Tulis jurnal kegiatanmu hari ini...">
            </textarea>
            <div class="flex justify-end mt-3">
                <button class="text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 px-5 py-2 rounded-xl transition-colors">
                    Simpan Jurnal
                </button>
            </div>
        </div>
    </div>
    @if($showModal && $selectedProduct)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-bold text-slate-800">{{ $selectedProduct->title }}</h2>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
    
            <div class="space-y-4">
                @php $asset = $selectedProduct->decoded_asset; @endphp

                @if(isset($asset['type']) && $asset['type'] === 'link')
                    @php $url = $asset['url']; @endphp
                    
                    @if(str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be'))
                        @php
                            $videoId = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        <div class="w-full aspect-video bg-black rounded-2xl overflow-hidden">
                            <iframe 
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/{{ $videoId }}" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <img src="{{ $url }}" class="w-full rounded-2xl shadow-sm" alt="Asset Image">
                    @endif

                @elseif(isset($asset['path']) && str_ends_with($asset['name'], '.pdf'))
                    <div class="w-full h-[80vh] bg-slate-100 rounded-2xl overflow-hidden border border-slate-200">
                        <iframe src="{{ Storage::url($asset['path']) }}#toolbar=0&navpanes=0" class="w-full h-full"></iframe>
                    </div>

                @elseif(isset($asset['path']) && (str_ends_with($asset['name'], '.mp4') || str_ends_with($asset['name'], '.mov')))
                    <div class="w-full bg-black rounded-2xl overflow-hidden">
                        <video controls playsinline class="w-full h-auto max-h-[70vh]">
                            <source src="{{ Storage::url($asset['path']) }}" type="video/mp4">
                        </video>
                    </div>

                @elseif(isset($asset['path']))
                    <img src="{{ Storage::url($asset['path']) }}" class="w-full rounded-2xl shadow-sm">
                @endif
            </div>
        </div>
    </div>
    @endif
    @if($showUploadModal && $selectedTask)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6">
            <h2 class="text-xl font-bold mb-4">Kumpul Tugas: {{ $selectedTask->title }}</h2>
            
            <form wire:submit.prevent="submitTask">
                <input type="file" wire:model="taskFile" class="w-full border rounded-xl p-2 mb-4">
                
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="closeUploadModal" class="text-slate-500 px-4 py-2">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endif
</div>