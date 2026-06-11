<div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
    <h2 class="text-xl font-black text-slate-800 mb-2 text-center">Login Area Admin</h2>
    <p class="text-xs text-slate-400 text-center mb-6">Silakan masuk menggunakan kredensial akun manajemen.</p>

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-600 mb-1">Email Resmi Admin</label>
            <input type="email" wire:model="email" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm focus:outline-none focus:border-indigo-600">
            @error('email') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 mb-1">Kata Sandi</label>
            <input type="password" wire:model="password" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm focus:outline-none focus:border-indigo-600">
            @error('password') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-3 rounded-xl transition shadow-sm">
            Masuk Sebagai Admin
        </button>
    </form>
</div>