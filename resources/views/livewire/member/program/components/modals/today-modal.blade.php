@if($showModal && $selectedProduct)

    <div class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-4">

        <div
            class="bg-white w-full h-[92vh] sm:h-auto sm:max-h-[92vh] sm:max-w-4xl rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col">

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
            
            <livewire:member.components.asset-viewer
                :product="$selectedProduct"
                :key="'modal-'.$selectedProduct->id"
            />

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