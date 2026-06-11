<div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
    <h2 class="text-xl font-black text-slate-800 mb-2 text-center">Login Member Area</h2>
    <p class="text-xs text-slate-400 text-center mb-6">Gunakan nomor WhatsApp Anda untuk mengakses riwayat produk.</p>

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-600 mb-1">Nomor WhatsApp</label>
            <input type="text" wire:model="whatsapp" placeholder="Contoh: 08123456789" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm focus:outline-none focus:border-indigo-600">
            @error('whatsapp') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 mb-1">Password</label>
            <input type="password" wire:model="password" placeholder="Masukkan password Anda" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm focus:outline-none focus:border-indigo-600">
            <span class="text-[10px] text-slate-400 mt-1 block">*Password bawaan Anda saat pertama beli adalah Nomor WhatsApp Anda sendiri.</span>
            @error('password') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 rounded-xl transition shadow-sm">
            Masuk Ke Member Area
        </button>
    </form>
</div>