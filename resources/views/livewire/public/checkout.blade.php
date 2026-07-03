<div class="w-full max-w-md min-h-screen bg-slate-50 shadow-xl flex flex-col justify-between relative border-x border-slate-200/50 mx-auto font-sans">
    
    {{-- Header --}}
    <div class="bg-white px-4 py-4 border-b border-slate-100 flex items-center sticky top-0 z-10 shadow-sm">
        <a href="javascript:void(0)" onclick="history.back()" class="text-slate-600 hover:text-slate-900 mr-3">
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
        @auth('member')
        @else
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider px-1">Informasi Pengiriman</h3>
            
            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model.defer="name" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 @error('name') border-rose-500 @enderror" placeholder="Contoh: Muhammad Bahrul">
                    @error('name') <span class="text-[11px] text-rose-500 font-medium mt-0.5">{{ $message }}</span> @enderror
                </div>
                <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    Email
                </label>
                <input 
                    type="email"
                    wire:model.defer="email"
                    class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 @error('email') border-rose-500 @enderror"
                    placeholder="Contoh: user@email.com">

                @error('email')
                    <span class="text-[11px] text-rose-500 font-medium mt-0.5">
                        {{ $message }}
                    </span>
                @enderror
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
        @endauth
       <div class="space-y-6">
            @foreach($paymentGroups as $groupName => $methods)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">
                        {{ $groupName }}
                    </h4>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($methods as $key => $data)
                            <div wire:key="method-{{ $key }}"
                                wire:click="$set('payment_method', '{{ $key }}')"
                                class="relative flex flex-col items-center justify-center p-4 rounded-xl border transition cursor-pointer hover:bg-slate-50
                                {{ $payment_method === $key ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-500' : 'border-slate-200 bg-white' }}">
                                
                                {{-- Ikon --}}
                                <img src="{{ $data['icon'] }}" class="w-10 h-10 object-contain mb-2">
                                
                                {{-- Label --}}
                                <span class="text-[11px] font-bold text-slate-600 text-center leading-tight">
                                    {{ $data['label'] }}
                                </span>

                                {{-- Indikator Terpilih --}}
                                @if($payment_method === $key)
                                    <div class="absolute top-2 right-2">
                                        <div class="w-3 h-3 bg-indigo-600 rounded-full"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white p-4 border-t border-slate-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] space-y-3 fixed bottom-0 left-0 right-0 max-w-md mx-auto z-20">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Total Yang Harus Dibayar:</span>
                <span class="text-base font-black text-indigo-600">
                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                </span>
            </div>
            
            <button
                type="submit"
                @disabled(empty($payment_method))
                wire:loading.attr="disabled"
                wire:target="processOrder"
                class="w-full block text-center font-bold text-sm py-3 px-4 rounded-xl shadow transition duration-150
                    disabled:bg-slate-300
                    disabled:text-slate-500
                    disabled:cursor-not-allowed
                    bg-indigo-600 hover:bg-indigo-700 text-white active:scale-95"
            >
                <span wire:loading.remove wire:target="processOrder">
                    {{ empty($payment_method) ? 'Pilih Metode Pembayaran' : 'Lanjut ke Pembayaran' }}
                </span>

                <span wire:loading wire:target="processOrder">
                    <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                    </svg>
                    Memproses Pesanan...
                </span>
            </button>
        </div>

    </form>

    @if($errors->has('checkout'))
        <div
            x-data="{ show: true }"
            x-init="
                setTimeout(() => {
                    window.location.href = '{{ url('/cart') }}';
                }, 2500)
            "
            x-show="show"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
        >
            <div
                x-transition.scale
                class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden"
            >
                <div class="p-8 text-center">

                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-100">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86l-8 14A1 1 0 003.16 19h17.68a1 1 0 00.87-1.5l-8-14a1 1 0 00-1.74 0z"/>
                        </svg>
                    </div>

                    <h2 class="mt-6 text-2xl font-bold text-slate-800">
                        Pembelian Ditolak
                    </h2>

                    <p class="mt-3 text-slate-500 leading-relaxed">
                        {{ $errors->first('checkout') }}
                    </p>

                    <p class="mt-6 text-xs text-slate-400">
                        Anda akan diarahkan kembali ke keranjang...
                    </p>
                </div>

                <div class="h-1 bg-slate-100">
                    <div
                        class="h-full bg-red-500"
                        x-init="$el.animate(
                            [{ width: '100%' }, { width: '0%' }],
                            { duration: 2500, fill: 'forwards' }
                        )"
                    ></div>
                </div>
            </div>
        </div>
        @endif
</div>