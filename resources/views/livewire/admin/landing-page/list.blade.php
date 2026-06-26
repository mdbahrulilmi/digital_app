<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-medium">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Halaman</h1>
            <p class="text-sm text-slate-500">Kelola semua halaman statis website Anda di sini.</p>
        </div>
        
        <button 
            wire:click="create"
            class="cursor-pointer flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-all shadow-md shadow-indigo-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Halaman
        </button>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between">
        <div class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="Cari judul atau slug...">
        </div>
        
        <select wire:model.live="filterStatus" class="cursor-pointer px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            <option value="">Semua Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div x-data="{ tab: 'pages' }">

    <!-- Tabs -->
    <div class="mb-6">
        <div class="inline-flex p-1 bg-slate-100 rounded-xl">

            <button
                @click="tab='pages'"
                :class="tab === 'pages'
                    ? 'bg-white text-indigo-600 shadow-sm'
                    : 'text-slate-500'"
                class="cursor-pointer px-5 py-2 rounded-lg font-semibold text-sm transition-all">
                Landing Page
            </button>

            <button
                @click="tab='programs'"
                :class="tab === 'programs'
                    ? 'bg-white text-indigo-600 shadow-sm'
                    : 'text-slate-500'"
                class="cursor-pointer px-5 py-2 rounded-lg font-semibold text-sm transition-all">
                Program Page
            </button>

        </div>
    </div>

    <!-- TAB LANDING PAGE -->
    <div x-show="tab === 'pages'" x-transition>
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Halaman</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Link</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Terakhir Diupdate</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @forelse($pages as $page)
                        <tr class="hover:bg-slate-50/50 transition-colors" wire:key="page-{{ $page->id }}">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-700">{{ $page->title }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-sm italic">/{{ $page->slug }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $page->updated_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($page->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button wire:click="edit({{ $page->id }})" class="cursor-pointer p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                <a href="{{ route('landingpage-editor', $page->id) }}" wire:navigate
                                        class="cursor-pointer p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 12C3.75 7.5 7.5 4.5 12 4.5S20.25 7.5 21.75 12C20.25 16.5 16.5 19.5 12 19.5S3.75 16.5 2.25 12z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        </svg>
                                    </a>
                                    <button onclick="confirm('Apakah Anda yakin ingin menghapus halaman ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $page->id }})" class="cursor-pointer p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">Tidak ada data halaman ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200">
                {{ $pages->links() }}
            </div>
        </div>
    </div>

    <!-- TAB PROGRAM PAGE -->
    <div
        x-show="tab === 'programs'"
        x-transition
        x-cloak
    >
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Halaman</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Link</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Terakhir Diupdate</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                       @forelse($program_pages as $page)
                        <tr class="hover:bg-slate-50/50 transition-colors" wire:key="page-{{ $page->id }}">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-700">{{ $page->title }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-sm italic">/{{ $page->slug }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $page->updated_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($page->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button wire:click="edit({{ $page->id }})" class="cursor-pointer p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                <a href="{{ route('landingpage-editor', $page->id) }}" wire:navigate
                                        class="cursor-pointer p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 12C3.75 7.5 7.5 4.5 12 4.5S20.25 7.5 21.75 12C20.25 16.5 16.5 19.5 12 19.5S3.75 16.5 2.25 12z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        </svg>
                                    </a>
                                    <button onclick="confirm('Apakah Anda yakin ingin menghapus halaman ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $page->id }})" class="cursor-pointer p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">Tidak ada data halaman ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200">
                {{ $program_pages->links() }}
            </div>
        </div>
    </div>

    </div>
    <livewire:admin.landing-page.components.modal.landing-page-form-modal />
</div>