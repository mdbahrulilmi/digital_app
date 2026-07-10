<div class="min-h-screen flex items-center justify-center bg-slate-50 p-4">
    <div class="w-full max-w-sm bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-8">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Buat Akun</h2>
            <p class="text-sm text-slate-500">Daftar untuk akses Member Area Anda</p>
        </div>

        
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-2xl text-xs font-medium flex items-center">
                <span class="mr-2">✅</span> {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="register" class="space-y-5">
            
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" wire:model="name" placeholder="Nama Anda" class="w-full bg-slate-50 border {{ $errors->has('name') ? 'border-rose-500' : 'border-slate-200' }} rounded-2xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                @error('name') <span class="text-rose-500 text-[11px] mt-1.5 ml-1 block">{{ $message }}</span> @enderror
            </div>

            
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Email</label>
                <input type="email" wire:model="email" placeholder="contoh@email.com" class="w-full bg-slate-50 border {{ $errors->has('email') ? 'border-rose-500' : 'border-slate-200' }} rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                @error('email') <span class="text-rose-500 text-[11px] mt-1 ml-1 block">{{ $message }}</span> @enderror
            </div>

            
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Nomor WhatsApp <span class="text-rose-500">*</span></label>
                <input type="text" wire:model="whatsapp" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="08123456789" class="w-full bg-slate-50 border {{ $errors->has('whatsapp') ? 'border-rose-500' : 'border-slate-200' }} rounded-2xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                @error('whatsapp') <span class="text-rose-500 text-[11px] mt-1.5 ml-1 block">{{ $message }}</span> @enderror
            </div>

            
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Password <span class="text-rose-500">*</span></label>
                <input type="password" wire:model="password" placeholder="••••••••" class="w-full bg-slate-50 border {{ $errors->has('password') ? 'border-rose-500' : 'border-slate-200' }} rounded-2xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                @error('password') <span class="text-rose-500 text-[11px] mt-1.5 ml-1 block">{{ $message }}</span> @enderror
            </div>

            
            {{-- <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Alamat</label>
                <textarea wire:model="address" rows="3" class="w-full bg-slate-50 border {{ $errors->has('address') ? 'border-rose-500' : 'border-slate-200' }} rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all resize-none"></textarea>
                @error('address') <span class="text-rose-500 text-[11px] mt-1 ml-1 block">{{ $message }}</span> @enderror
            </div> --}}

            <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-semibold text-sm py-3.5 rounded-2xl transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-500/20">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-[11px] text-slate-400">Sudah punya akun? <a href="/login" class="text-indigo-600 font-bold hover:underline">Masuk Sekarang</a></p>
        </div>
    </div>
</div>