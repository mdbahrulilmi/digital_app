@php
    $selectedProduct = !empty($editingContent['product_id'])
        ? \App\Models\Product::find($editingContent['product_id'])
        : null;

    $content = array_merge([
        'title' => 'Nama Produk',
        'description' => 'Deskripsi produk belum tersedia.',
        'price' => 0,
        'old_price' => null,
        'image_url' => null,
        'badge' => 'Promo',
        'button_text' => 'Beli',
        'product_style' => 'card',
    ], $editingContent);

    if ($selectedProduct) {
        $content['id'] = $selectedProduct->id;
        $content['title'] = $selectedProduct->title;
        $content['description'] = $selectedProduct->description;
        $content['price'] = $selectedProduct->price;
        $content['slug'] = $selectedProduct->slug;
        $content['image_url'] = $selectedProduct->image
            ? asset($selectedProduct->image)
            : null;
    }

    $style = $content['product_style'] ?? 'card';
@endphp

<div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

    {{-- ================= LEFT ================= --}}
    <div class="xl:col-span-3">

        <div class="sticky top-4">

            <div class="bg-slate-100 border border-slate-200 rounded-xl p-5">

                <div class="w-full mx-auto">

                    @include(
                        'livewire.admin.landing-page.components.product.' . $style,
                        ['content' => $content]
                    )

                </div>

            </div>

        </div>

    </div>



    {{-- ================= RIGHT ================= --}}
    <div class="space-y-5 xl:col-span-2">

        {{-- Style --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5">

            <h3 class="font-semibold text-slate-800 mb-4">
                Tampilan
            </h3>

            <label class="block text-xs font-medium text-slate-600 mb-2">
                Style Produk
            </label>

            <select
                wire:model.live="editingContent.product_style"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                <option value="card">
                    🛍️ Full Card
                </option>

                <option value="compact">
                    📋 Compact
                </option>

            </select>

        </div>


        {{-- Produk --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5">

            <h3 class="font-semibold text-slate-800 mb-4">
                Produk
            </h3>

            <label class="block text-xs font-medium text-slate-600 mb-2">
                Pilih Produk
            </label>

            <select
                wire:model.live="editingContent.product_id"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                <option value="">
                    -- Pilih Produk --
                </option>

                @foreach($products as $product)

                    <option value="{{ $product->id }}">
                        {{ $product->title }}
                        •
                        Rp {{ number_format($product->price,0,',','.') }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Promo --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5">

            <h3 class="font-semibold text-slate-800 mb-4">
                Promo
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-xs font-medium text-slate-600 mb-2">
                        Harga Coret
                    </label>

                    <input
                        type="number"
                        wire:model.live="editingContent.old_price"
                        placeholder="150000"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                </div>


                <div>

                    <label class="block text-xs font-medium text-slate-600 mb-2">
                        Badge
                    </label>

                    <input
                        type="text"
                        wire:model.live="editingContent.badge"
                        placeholder="Promo"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                </div>

            </div>

        </div>
        
        <div class="bg-white border border-slate-200 rounded-xl p-5">

            <h3 class="font-semibold text-slate-800 mb-4">
                Promo
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-xs font-medium text-slate-600 mb-2">
                        Harga Coret
                    </label>

                    <input
                        type="number"
                        wire:model.live="editingContent.old_price"
                        placeholder="150000"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                </div>


                <div>

                    <label class="block text-xs font-medium text-slate-600 mb-2">
                        Badge
                    </label>

                    <input
                        type="text"
                        wire:model.live="editingContent.badge"
                        placeholder="Promo"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                </div>

            </div>

        </div>

    </div>

</div>