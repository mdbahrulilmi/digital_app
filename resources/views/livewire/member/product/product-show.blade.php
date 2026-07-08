<div class="p-4">

    <h1 class="text-3xl font-bold text-slate-900 mb-6">
        {{ $product->title }}
    </h1>

    <livewire:member.components.asset-viewer
        :product="$product"
        :key="$product->id"
    />

    <div class="mt-8 prose prose-slate max-w-none">

        <h3 class="text-xl font-semibold">
            Deskripsi
        </h3>

        <p class="text-slate-600">
            {{ $product->description }}
        </p>

    </div>

</div>