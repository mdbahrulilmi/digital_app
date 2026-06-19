<div class="max-w-4xl mx-auto py-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Sistem</h1>
        <p class="text-slate-500">Konfigurasi dasar aplikasi Anda.</p>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div>
                <label class="font-semibold text-slate-700">Nama Aplikasi</label>
                <p class="text-sm text-slate-400">Nama yang muncul di header dashboard.</p>
            </div>
            <input type="text" wire:model="app_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <hr class="border-slate-100">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div>
                <label class="font-semibold text-slate-700">Email Admin</label>
                <p class="text-sm text-slate-400">Email untuk notifikasi transaksi.</p>
            </div>
            <input type="email" wire:model="email_admin" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <hr class="border-slate-100">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div>
                <label class="font-semibold text-slate-700">Maintenance Mode</label>
                <p class="text-sm text-slate-400">Aktifkan untuk membatasi akses publik.</p>
            </div>
            <div class="flex items-center">
                <input type="checkbox" wire:model="maintenance_mode" class="w-5 h-5 text-indigo-600 rounded">
            </div>
        </div>

        <div class="pt-4 border-t flex justify-end">
            <button wire:click="save" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg hover:bg-slate-800 transition">
                Simpan Pengaturan
            </button>
        </div>
    </div>
</div>