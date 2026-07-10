<div class="p-6">
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Ganti Kata Sandi</h2>
        
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-bold">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="updatePassword" class="space-y-6">
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi Saat Ini</label>
                <input wire:model="current_password" type="password" class="w-full p-4 rounded-xl border {{ $errors->has('current_password') ? 'border-red-500' : 'border-slate-200' }} focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="••••••••">
                @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="border-t border-slate-100 pt-6 space-y-6">
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi Baru</label>
                    <input wire:model="new_password" type="password" class="w-full p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Minimal 8 karakter">
                    @error('new_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                    <input wire:model="new_password_confirmation" type="password" class="w-full p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Ulangi kata sandi baru">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-xl font-bold hover:bg-indigo-600 transition-all active:scale-95">
                    <span wire:loading.remove>Perbarui Kata Sandi</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>