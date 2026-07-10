
<div class="bg-slate-100 antialiased min-h-screen relative overflow-x-hidden">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-200/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-violet-200/50 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.04)_1px,transparent_0)] [background-size:28px_28px]"></div>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <div class="flex items-center gap-2.5 mb-6">
            <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z"/>
                </svg>
            </div>
            <span class="font-extrabold text-slate-900 text-lg tracking-tight">Admin Panel</span>
        </div>

        
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
        

        
        <p class="mt-6 text-center text-xs text-slate-400 max-w-md px-4">
            &copy; {{ date('Y') }} Sukawebsite. Halaman ini hanya untuk admin.
        </p>
    </div>
</div>