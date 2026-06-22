<div>
    {{-- Main Container Card --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-slate-800">
                Daftar member 
                <span class="text-[10px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full">
                    {{ $members->total() }}
                </span>
            </h2>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama..." 
                   class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 outline-none w-48">
        </div>

        <table class="w-full text-sm text-left">
            <thead class="text-slate-400 uppercase text-[10px]">
                <tr>
                    <th class="pb-3">Nama</th>
                    <th class="pb-3">No Whatsapp</th>
                    <th class="pb-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($members as $member)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 font-medium text-slate-700">{{ $member->name }}</td>
                        <td class="py-3 text-slate-500">{{ $member->whatsapp }}</td>
                        <td class="py-3 text-right">
                            <button wire:click="openJournal({{ $member->id }})" 
                                    class="text-[10px] bg-indigo-50 text-indigo-600 px-3 py-1 rounded-md hover:bg-indigo-100 transition">
                                Lihat Jurnal
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">{{ $members->links() }}</div>
    </div>

    {{-- Modal dengan Background Putih (Konsisten) --}}
    @if($showJournalModal && $selectedMember)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
            {{-- Wrapper Putih dengan Shadow yang sama seperti card lainnya --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-lg w-full max-w-lg p-6 animate-in fade-in zoom-in duration-200">
                <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-4">
                    <h3 class="font-semibold text-slate-800 text-sm">Jurnal: {{ $selectedMember->name }}</h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>
                
                <div class="space-y-3 max-h-96 overflow-y-auto pr-2 scrollbar-thin">
                    @foreach($this->getMemberJournals($selectedMember->id) as $journal)
                        <div class="p-3 border border-slate-100 rounded-lg bg-slate-50/50 hover:bg-white hover:border-indigo-100 transition">
                            <p class="text-xs font-medium text-slate-700">{{ $journal['title'] }}</p>
                            <p class="text-[10px] text-slate-400 mt-1">{{ $journal['date'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>