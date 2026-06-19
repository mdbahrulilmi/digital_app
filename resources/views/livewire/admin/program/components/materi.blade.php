<div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-6">Jadwal Materi per Hari</h2>
    
    <div class="space-y-4">
        @foreach($this->dates as $date)
        @php $dateKey = $date->format('Y-m-d'); @endphp
        <div class="grid grid-cols-4 gap-4 p-4 border border-slate-100 rounded-lg hover:border-indigo-100 transition">
            <div class="font-semibold text-slate-700">
                {{ $date->format('d M Y') }}
            </div>
            
            <div class="col-span-3 space-y-2">
                @foreach(($schedules[$dateKey] ?? []) as $index => $selectedId)
                    <div class="flex gap-2 animate-in fade-in duration-300">
                        <select wire:model="schedules.{{ $dateKey }}.{{ $index }}" 
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Produk...</option>
                            @foreach($allProducts as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="removeProductSlot('{{ $dateKey }}', {{ $index }})" 
                                class="text-red-400 hover:text-red-600 px-3">Hapus</button>
                    </div>
                @endforeach

                <button type="button" wire:click="addProductSlot('{{ $dateKey }}')" 
                        class="text-xs text-indigo-600 font-bold hover:underline py-2">
                    + Tambah Materi Lain
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    <button wire:click="saveSchedule" 
            class="cursor-pointer mt-8 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition">
        Simpan Semua Jadwal
    </button>
</div>