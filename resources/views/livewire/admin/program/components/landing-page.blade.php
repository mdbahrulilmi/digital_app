<div class="space-y-8">
    @if($section)
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $section->title }}</h2>
                    <p class="text-sm text-slate-500 font-mono mt-1">URL: /{{ $section->slug }}</p>
                </div>
                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                    {{ $section->status }}
                </span>
            </div>

            <div class="my-6 border-t border-slate-100"></div>

            <div class="flex justify-end">
                <a href="/admin/landing-page/{{$section->id}}/edit" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Halaman Utama
                </a>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Daftar Halaman Relasi</h3>
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Judul Halaman</th>
                            <th class="px-6 py-3 font-semibold">Slug</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($subPages as $subPage)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $subPage->title }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-indigo-600">/{{ $subPage->slug }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-[10px] font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded">
                                        {{ $subPage->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400 italic">Tidak ada halaman relasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-200">
            <p class="text-sm text-slate-400">Data landing page belum tersedia.</p>
        </div>
    @endif
</div>