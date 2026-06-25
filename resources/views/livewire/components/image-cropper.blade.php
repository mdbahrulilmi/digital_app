<div x-data="imageCropper('{{ $wireModel }}', {{ $aspectRatio ?? 1 }})" class="w-full">
    
    <div class="relative">
        <input
            type="file"
            accept="image/*"
            @change="openCropper($event)"
            class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer"
        >
    </div>

    <div
        x-show="show"
        x-cloak
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
    >
        <div class="bg-white rounded-3xl shadow-2xl p-6 w-full max-w-2xl transform transition-all" 
             @click.away="close()">
            
            <h3 class="text-lg font-bold text-slate-800 mb-4">Potong Gambar</h3>
            
            <div class="bg-slate-100 rounded-xl overflow-hidden min-h-[300px] flex items-center justify-center">
                <img
                    x-ref="image"
                    class="max-w-full max-h-[500px]"
                >
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button
                    type="button"
                    @click="close()"
                    class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition"
                >
                    Batal
                </button>

                <button
                    type="button"
                    @click="save()"
                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-semibold shadow-lg shadow-indigo-200"
                >
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>