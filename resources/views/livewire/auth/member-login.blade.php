<div class="min-h-screen flex items-center justify-center bg-slate-50 p-4">
    <div class="w-full max-w-sm bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-8">
        @if (session()->has('message'))
            <div class="p-4 mb-4 bg-emerald-50 text-emerald-600 rounded-2xl text-xs">
                {{ session('message') }}
            </div>
        @endif
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Selamat Datang</h2>
            <p class="text-sm text-slate-500">Silakan masuk ke Member Area Anda</p>
        </div>

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-600 border border-rose-100 rounded-2xl text-xs font-medium flex items-center">
                <span class="mr-2">⚠️</span> {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="login" class="space-y-5">
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Nomor WhatsApp</label>
                <input type="text" wire:model="whatsapp" placeholder="0812xxxx" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                @error('whatsapp') <span class="text-rose-500 text-[11px] mt-1.5 ml-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Password</label>
                </div>
                <input type="password" wire:model="password" placeholder="••••••••" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                <p class="text-[10px] text-slate-400 mt-2 ml-1 leading-relaxed">
                    *Password default adalah nomor WhatsApp Anda.
                </p>
                @error('password') <span class="text-rose-500 text-[11px] mt-1.5 ml-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" 
                class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-semibold text-sm py-3.5 rounded-2xl transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-500/20">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-[11px] text-slate-400">
                Belum punya akun? 
                <a href="/register" class="text-indigo-600 font-bold hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>