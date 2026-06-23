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

        {{-- Modal Jurnal --}}
        @if($showJournalModal && $selectedMember)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-200">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col max-h-[85vh] overflow-hidden animate-in zoom-in-95 duration-200">
                    
                    {{-- Header --}}
                    <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Jurnal Refleksi</h3>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-0.5">{{ $selectedMember->name }}</p>
                        </div>
                        <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 p-2 hover:bg-slate-200 rounded-full transition">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>
                    
                    {{-- Konten Jurnal (Dibuat lebih bersih) --}}
                    <div class="p-6 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200">
                        @php $journals = $this->getMemberJournals($selectedMember->id); @endphp
                        
                        <div class="space-y-8">
                            @forelse($journals as $journal)
                                <div class="relative pl-6 border-l-2 border-indigo-100">
                                    <div class="absolute -left-[7px] top-0 w-3 h-3 bg-indigo-500 rounded-full shadow-sm ring-4 ring-white"></div>
                                    <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm hover:border-indigo-100 transition-all">
                                        <p class="text-sm text-slate-600 leading-relaxed italic">"{{ $journal['title'] }}"</p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <div class="bg-slate-50 p-6 rounded-full mb-4 text-slate-300">
                                        <x-heroicon-o-document-text class="w-10 h-10" />
                                    </div>
                                    <p class="text-sm font-semibold text-slate-600">Belum ada jurnal</p>
                                    <p class="text-xs text-slate-400 mt-1">Member ini belum menulis catatan refleksi.</p>
                                </div>
                            @endforelse

                            {{-- Tombol Muat Lebih Banyak --}}
                            @if($journals->hasMorePages())
                                <div class="text-center pt-2">
                                    <button wire:click="loadMoreJournals" 
                                            class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest px-4 py-2 bg-indigo-50 rounded-lg">
                                        Muat Jurnal Lama...
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>