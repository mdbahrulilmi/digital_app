<div class="w-full max-w-md min-h-screen bg-slate-50 shadow-xl flex flex-col justify-between relative border-x border-slate-200/50 mx-auto font-sans">
    
    <div class="bg-white px-4 py-4 border-b border-slate-100 flex items-center sticky top-0 z-10 shadow-sm">
        
        <a href="javascript:void(0)" onclick="history.back()" class="text-slate-600 hover:text-slate-900 mr-3 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        
        <h2 class="text-lg font-bold text-slate-800">Keranjang Belanja</h2>
    </div>

    <div class="flex-1 p-4 space-y-4 overflow-y-auto">
        @if(session()->has('success'))
            <div class="bg-emerald-50 text-emerald-600 text-xs p-3 rounded-xl border border-emerald-100 font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            @foreach($cart as $id => $item)
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between gap-3">
                    
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ $item['name'] }}</h4>
                        <p class="text-xs text-rose-500 font-black mt-1">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">

                        <button
                            type="button"
                            wire:click="removeItem('{{ $id }}')"
                            class="text-slate-400 hover:text-rose-600 transition cursor-pointer"
                            title="Hapus item">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>

                        </button>

                    </div>

                </div>
            @endforeach
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center space-y-3">
                <div class="p-4 bg-slate-100 rounded-full text-slate-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-700">Keranjangmu Kosong</h3>
                    <p class="text-xs text-slate-400 mt-1">Belum ada produk yang ditambahkan nih.</p>
                </div>
                <a href="{{ url('/') }}" class="inline-block bg-indigo-600 text-white font-bold text-xs px-4 py-2 rounded-xl shadow transition active:scale-95">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    @if(count($cart) > 0)
        <div class="bg-white p-4 border-t border-slate-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] space-y-3 sticky bottom-0">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Total Pembayaran:</span>
                <span class="text-base font-black text-indigo-600">
                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                </span>
            </div>
            
            <a href="{{ url('/checkout') }}" class="w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 px-4 rounded-xl shadow transition duration-150 transform active:scale-95">
                Lanjut ke Pembayaran
            </a>
        </div>
    @endif

</div>