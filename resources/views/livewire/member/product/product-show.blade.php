<div class="p-4 ">
    <h1 class="text-3xl font-bold text-slate-900 mb-6">{{ $product->title }}</h1>

    @php
        $asset = $product->decoded_asset ?? null;
    @endphp

    @if($asset)
        <div class="mt-4 w-full">
            @if(($asset['type'] ?? '') === 'link')
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ $asset['url'] }}" class="w-full h-auto" alt="Product Image">
                </div>
            @else
                @php
                    $filePath = $asset['path'] ?? '';
                    $extension = strtolower($asset['type'] ?? pathinfo($filePath, PATHINFO_EXTENSION));
                    $fullUrl = asset('storage/' . $filePath);
                @endphp

                <div class="w-full">
                    @if($extension === 'pdf')
                            <div class="w-full h-[80vh] bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                                <iframe src="{{ $fullUrl }}" class="w-full h-full" frameborder="0"></iframe>
                            </div>

                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                        <div class="w-full h-[85vh] bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                            <iframe
                                 src="https://docs.google.com/gview?embedded=true&url={{ urlencode($fullUrl) }}"
                                class="w-full h-full"
                                frameborder="0">
                            </iframe>
                        </div>
                    
                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                        <div class="rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ $fullUrl }}" class="w-full h-auto" alt="Image">
                        </div>
                    @elseif(in_array($extension, ['mp4', 'mov', 'webm']))
                        <div class="rounded-2xl overflow-hidden shadow-2xl bg-black">
                            <video controls class="w-full aspect-video">
                                <source src="{{ $fullUrl }}" type="video/{{ $extension }}">
                                Browser Anda tidak mendukung pemutar video.
                            </video>
                        </div>
                    @elseif(in_array($extension, ['mp3', 'wav', 'ogg']))
                        <div class="p-8 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg">
                            <audio controls class="w-full max-w-md">
                                <source src="{{ $fullUrl }}" type="audio/{{ $extension }}">
                            </audio>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @else
        <div class="p-8 bg-slate-100 rounded-2xl text-center text-slate-500">
            Asset atau media tidak tersedia untuk produk ini.
        </div>
    @endif

    <div class="mt-8 prose prose-slate max-w-none">
        <h3 class="text-xl font-semibold">Deskripsi</h3>
        <p class="text-slate-600">{{ $product->description }}</p>
    </div>
</div>