<div>
    <div class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">

            <span class="text-sm font-bold text-slate-800">Keranjang Belanja</span>

            <a href="{{ route('public.cart') }}"
                class="cursor-pointer relative p-2 text-slate-700 hover:text-indigo-600 hover:bg-slate-50 rounded-xl transition-all">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25L5.106 5.272" />
                </svg>

                @if(count(session('cart', [])) > 0)
                    <span class="absolute top-0 right-0 flex h-4 min-w-[16px] px-1 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white ring-2 ring-white">
                        {{ count(session('cart', [])) }}
                    </span>
                @endif
            </a>

        </div>
    </div>
</div>