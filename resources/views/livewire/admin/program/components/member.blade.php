    <div>
        
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
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-lg transition-all duration-200">
                                    <x-heroicon-o-book-open class="w-3 h-3" />
                                    Jurnal
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">{{ $members->links() }}</div>
        </div>

        @if($showJournalModal && $selectedMember)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md h-[550px] flex flex-col overflow-hidden animate-in zoom-in-95 duration-200">
                    
                    
                    <div class="flex-none flex justify-between items-center px-6 py-4 border-b border-slate-100">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Jurnal Refleksi</h3>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ $selectedMember->name }}</p>
                        </div>
                        <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>
                    
                    
                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        @php $journals = $this->getMemberJournals($selectedMember->id); @endphp
                        
                        @forelse($journals as $journal)
                            <div class="bg-white border border-slate-100 p-3 rounded-xl flex items-center justify-between gap-3 hover:border-indigo-200 transition-all">
                                <div class="min-w-0 flex-1">
                                    
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[10px] text-slate-400 font-medium">{{ $journal['date'] }}</span>
                                        @if($journal['comment'])
                                            <span class="text-[9px] bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded font-bold uppercase tracking-tighter">
                                                Ada Komentar
                                            </span>
                                        @endif
                                    </div>
                                    
                                    
                                    <p class="text-xs text-slate-700 truncate font-medium">{{ $journal['title'] }}</p>
                                </div>

                                
                                <button wire:click="openCommentModal({{ $journal['id'] }})" 
                                        class="flex-none text-[10px] text-indigo-600 font-bold hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition border border-indigo-100">
                                    {{ $journal['comment'] ? 'Edit' : 'Beri' }}
                                </button>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 text-xs">Belum ada jurnal yang tersedia.</div>
                        @endforelse

                        @if($journals->hasMorePages())
                            <button wire:click="loadMoreJournals" class="w-full py-3 text-[10px] font-bold text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition">
                                Muat lebih banyak
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if($showCommentModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl w-full max-w-lg p-5">

                <h3 class="font-semibold text-slate-800 mb-4">
                    Komentar Jurnal
                </h3>

                <textarea
                    wire:model="commentText"
                    rows="5"
                    class="w-full border border-slate-300 rounded-lg p-3"
                    placeholder="Tulis komentar..."
                ></textarea>

                <div class="flex justify-end gap-2 mt-4">

                    <button
                        wire:click="closeCommentModal"
                        class="px-4 py-2 border rounded-lg"
                    >
                        Batal
                    </button>

                    <button
                        wire:click="saveComment"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg"
                    >
                        Simpan
                    </button>

                </div>

            </div>

        </div>
        @endif
    </div>