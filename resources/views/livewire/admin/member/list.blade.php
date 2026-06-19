<div class="space-y-4">
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <h2 class="text-xl font-bold text-slate-800">Data Member</h2>
        
        <!-- Search Bar dengan style yang lebih "match" -->
        <div class="relative">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Cari nama atau email..." 
                class="w-full md:w-64 pl-4 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            >
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto"> <!-- Biar tabel responsif di HP -->
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama</th>
                        <th class="px-6 py-3 font-semibold">Whatsapp</th>
                        <th class="px-6 py-3 font-semibold">Terdaftar</th>
                        <th class="px-6 py-3 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $member)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $member->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $member->whatsapp }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $member->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-slate-500">#</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <span class="text-sm">Tidak ada data ditemukan untuk "{{ $search }}"</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Footer Table -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $members->links() }}
        </div>
    </div>
</div>