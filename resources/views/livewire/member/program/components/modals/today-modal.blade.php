@if($showModal && $selectedProduct)

    <div class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-4">

        <div
            class="bg-white w-full h-[92vh] sm:h-auto sm:max-h-[92vh] sm:max-w-4xl rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-6 sm:py-5">

                <div class="min-w-0">

                    <h2 class="text-lg sm:text-2xl font-bold text-slate-800 truncate">
                        {{ $selectedProduct->title }}
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Materi Pembelajaran
                    </p>

                </div>

                <button
                    wire:click="closeModal"
                    class="w-10 h-10 rounded-full hover:bg-slate-100 transition flex items-center justify-center flex-shrink-0">

                    <svg class="w-5 h-5 text-slate-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>

                    </svg>

                </button>

            </div>

            {{-- Content --}}
            <div class="flex-1 overflow-y-auto p-4 sm:p-6">

                @php
                    $asset = $selectedProduct->decoded_asset;
                    $path = $asset['path'] ?? '';
                    $type = $asset['type'] ?? '';

                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    $fullUrl = Storage::url($path);
                @endphp

                @if($type === 'link')

                    {{-- Youtube --}}
                    @if(str_contains($asset['url'] ?? '', 'youtube.com') || str_contains($asset['url'] ?? '', 'youtu.be'))

                        @php
                            $videoId = '';

                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $asset['url'], $matches);

                            $videoId = $matches[1] ?? '';
                        @endphp

                        <div class="rounded-2xl overflow-hidden bg-black shadow">

                            <iframe
                                class="w-full aspect-video"
                                src="https://www.youtube.com/embed/{{ $videoId }}"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen>
                            </iframe>

                        </div>

                    @else

                        <img
                            src="{{ $asset['url'] }}"
                            class="w-full max-h-[70vh] object-contain rounded-2xl mx-auto"
                            alt="Asset">

                    @endif

                @elseif($path)

                    {{-- PDF --}}
                    @if($extension === 'pdf')

                        <div class="w-full h-[65vh] sm:h-[80vh] rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">

                            <iframe
                                src="{{ $fullUrl }}#toolbar=0&navpanes=0"
                                class="w-full h-full">
                            </iframe>

                        </div>

                    {{-- Video --}}
                    @elseif(in_array($extension,['mp4','mov','webm']))

                        <div class="rounded-2xl overflow-hidden bg-black shadow">

                            <video
                                controls
                                playsinline
                                preload="metadata"
                                class="w-full aspect-video object-contain bg-black">

                                <source
                                    src="{{ $fullUrl }}"
                                    type="video/{{ $extension }}">

                                Browser tidak mendukung video.

                            </video>

                        </div>

                    {{-- Audio --}}
                    @elseif(in_array($extension,['mp3','wav','ogg']))

                        <div class="rounded-2xl bg-slate-900 p-6 sm:p-8">

                            <audio controls class="w-full">

                                <source
                                    src="{{ $fullUrl }}"
                                    type="audio/{{ $extension }}">

                            </audio>

                        </div>

                    {{-- Image --}}
                    @elseif(in_array($extension,['jpg','jpeg','png','webp']))

                        <img
                            src="{{ $fullUrl }}"
                            class="w-full max-h-[70vh] object-contain rounded-2xl mx-auto shadow"
                            alt="Asset">

                    {{-- Unsupported --}}
                    @else

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 py-16 px-6 text-center">

                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6M9 8h6"/>

                            </svg>

                            <p class="font-semibold text-slate-700">
                                Format file tidak didukung
                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                .{{ $extension }}
                            </p>

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