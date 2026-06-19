<div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 w-full">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-slate-800">Jadwal Webinar</h2>
        
        <div class="flex items-center gap-2">
            <button type="button" wire:click="addZoomField" 
                    class="cursor-pointer bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 transition">
                + Tambah Sesi
            </button>
            
            <button type="button" wire:click="saveZooms" 
                    class="cursor-pointer bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
                <span wire:loading.remove wire:target="saveZooms">Simpan Jadwal</span>
                <span wire:loading wire:target="saveZooms">Menyimpan...</span>
            </button>
        </div>
    </div>
    
    {{-- Pesan Sukses --}}
    @if (session()->has('message'))
        <div class="bg-green-50 text-green-700 p-3 rounded-lg text-sm mb-4 border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <div class="w-full overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="text-left text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-100">
                    <th class="pb-4 px-2 w-[20%]">Tanggal</th>
                    <th class="pb-4 px-2 w-[15%]">Mulai</th>
                    <th class="pb-4 px-2 w-[15%]">Selesai</th>
                    <th class="pb-4 px-2 w-[40%]">Zoom URL</th>
                    <th class="pb-4 px-2 w-[10%] text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($zoomLinks as $index => $link)
                <tr class="group hover:bg-slate-50">
                    <td class="py-3 px-2 align-top">
                        <input type="date" wire:model="zoomLinks.{{$index}}.date" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                        @error("zoomLinks.$index.date") <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div> @enderror
                    </td>
                    <td class="py-3 px-2 align-top">
                        <input type="time" wire:model="zoomLinks.{{$index}}.start_time" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                        @error("zoomLinks.$index.start_time") <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div> @enderror
                    </td>
                    <td class="py-3 px-2 align-top">
                        <input type="time" wire:model="zoomLinks.{{$index}}.end_time" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                        @error("zoomLinks.$index.end_time") <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div> @enderror
                    </td>
                    <td class="py-3 px-2 align-top">
                        <input type="text" wire:model="zoomLinks.{{$index}}.url" placeholder="https://zoom.us/j/..." class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                        @error("zoomLinks.$index.url") <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div> @enderror
                    </td>
                    <td class="py-3 px-2 text-center align-top">
                        <button type="button" 
                                wire:click="removeZoomField({{ $index }})" 
                                class="cursor-pointer bg-red-50 text-red-600 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-red-100 transition">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>