<div class="w-full max-w-md min-h-screen bg-white shadow-xl mx-auto border-x border-slate-200/50 flex flex-col relative">
    
    <div class="flex-grow p-6 pb-24">
        <img src="{{ asset($this->product->image) }}" class="w-full h-64 object-cover rounded-3xl mb-6">
        
        <h1 class="text-2xl font-black text-slate-900">{{ $this->product->title }}</h1>
        <p class="text-xl font-bold text-indigo-600 my-4">Rp {{ number_format($this->product->price, 0, ',', '.') }}</p>
        
        <div class="prose prose-sm text-slate-600">
            {{ $this->product->description }}
        </div>
    </div>

    <div class="sticky bottom-0 left-0 w-full p-4 bg-white border-t border-slate-100 z-10">
        <button wire:click="buyNow" 
                class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-indigo-700 transition active:scale-95">
            Beli Sekarang
        </button>
    </div>
</div>