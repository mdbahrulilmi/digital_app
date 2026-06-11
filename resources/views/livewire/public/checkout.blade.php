<div class="w-full max-w-md min-h-screen bg-slate-50 shadow-xl flex flex-col justify-between relative border-x border-slate-200/50 mx-auto font-sans">
    
    {{-- Header --}}
    <div class="bg-white px-4 py-4 border-b border-slate-100 flex items-center sticky top-0 z-10 shadow-sm">
        <a href="{{ url('/cart') }}" class="text-slate-600 hover:text-slate-900 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-lg font-bold text-slate-800">Formulir Checkout</h2>
    </div>

    {{-- Main Content --}}
    <form wire:submit.prevent="processOrder" class="flex-1 p-4 space-y-6 overflow-y-auto pb-24">
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-2">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ringkasan Pesanan</h3>
            <div class="divide-y divide-slate-100">
                @foreach($cart as $item)
                    <div class="py-2 flex justify-between text-sm gap-2">
                        <span class="text-slate-700 font-medium truncate">{{ $item['name'] }} <span class="text-xs text-slate-400">x{{ $item['qty'] }}</span></span>
                        <span class="text-slate-900 font-bold shrink-0">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Data Pengiriman Form --}}
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider px-1">Informasi Pengiriman</h3>
            
            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model.defer="name" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 @error('name') border-rose-500 @enderror" placeholder="Contoh: Muhammad Bahrul">
                    @error('name') <span class="text-[11px] text-rose-500 font-medium mt-0.5">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" wire:model.defer="whatsapp" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 @error('whatsapp') border-rose-500 @enderror" placeholder="Contoh: 081234567890">
                    @error('whatsapp') <span class="text-[11px] text-rose-500 font-medium mt-0.5">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                    <textarea wire:model.defer="address" rows="3" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 @error('address') border-rose-500 @enderror" placeholder="Nama Jalan, No. Rumah, RT/RW, Kecamatan, Kota/Kabupaten, Provinsi"></textarea>
                    @error('address') <span class="text-[11px] text-rose-500 font-medium mt-0.5">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Pilihan Metode Pembayaran Terintegrasi --}}
        <div class="space-y-3">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider px-1">Metode Pembayaran</h3>
            
            @error('payment_method') <span class="text-[11px] text-rose-500 font-medium block px-1">{{ $message }}</span> @enderror
            
            <div class="grid grid-cols-1 gap-2">
                <label class="border rounded-xl p-3 flex items-center justify-between bg-white cursor-pointer transition hover:border-slate-300 {{ $payment_method === 'qris' ? 'border-indigo-600 ring-2 ring-indigo-50/50' : 'border-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <input type="radio" wire:model="payment_method" value="qris" class="text-indigo-600 focus:ring-indigo-500">
                        <div class="text-sm font-bold text-slate-800">QRIS (Otomatis / E-Wallet)</div>
                    </div>
                </label>
                <label class="border rounded-xl p-3 flex items-center justify-between bg-white cursor-pointer transition hover:border-slate-300 {{ $payment_method === 'alfamart' ? 'border-indigo-600 ring-2 ring-indigo-50/50' : 'border-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <input type="radio" wire:model="payment_method" value="alfamart" class="text-indigo-600 focus:ring-indigo-500">
                        <div class="text-sm font-bold text-slate-800">Alfamart Gerai Ritel</div>
                    </div>
                </label>
                <label class="border rounded-xl p-3 flex items-center justify-between bg-white cursor-pointer transition hover:border-slate-300 {{ $payment_method === 'indomaret' ? 'border-indigo-600 ring-2 ring-indigo-50/50' : 'border-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <input type="radio" wire:model="payment_method" value="indomaret" class="text-indigo-600 focus:ring-indigo-500">
                        <div class="text-sm font-bold text-slate-800">Indomaret Gerai Ritel</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="bg-white p-4 border-t border-slate-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] space-y-3 fixed bottom-0 left-0 right-0 max-w-md mx-auto z-20">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Total Yang Harus Dibayar:</span>
                <span class="text-base font-black text-indigo-600">
                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                </span>
            </div>
            
            <button type="submit" wire:loading.attr="disabled" class="w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 px-4 rounded-xl shadow transition duration-150 transform active:scale-95 cursor-pointer">
                <span wire:loading.remove>Lanjut ke Pembayaran</span>
                <span wire:loading>Memproses Pesanan...</span>
            </button>
        </div>

    </form>
</div>