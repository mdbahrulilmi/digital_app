<div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 w-full">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-slate-800">Jadwal Webinar</h2>
        
        <div class="flex items-center gap-2">
            <button type="button" wire:click="addZoomField" 
                    class="cursor-pointer bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 transition">
                + Tambah Sesi
            </button>
            
            <button type="button" wire:click="save" 
                    class="cursor-pointer bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
                <span wire:loading.remove wire:target="save">Simpan Jadwal</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </div>
    
    {{-- Notifikasi --}}
    @if(session()->has('message'))
        <div class="mb-4 flex items-center gap-2 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2.5">
            <x-heroicon-o-check-circle class="w-4 h-4 shrink-0" />
            {{ session('message') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="mb-4 flex items-center gap-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2.5">
            <x-heroicon-o-x-circle class="w-4 h-4 shrink-0" />
            {{ session('error') }}
        </div>
    @endif

    <div class="w-full overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="text-left text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-100">
                    <th class="pb-4 px-2 w-[20%]">Judul</th>
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
                        <input type="text" wire:model="zoomLinks.{{$index}}.title" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                        @error("zoomLinks.$index.title") <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div> @enderror
                    </td>
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