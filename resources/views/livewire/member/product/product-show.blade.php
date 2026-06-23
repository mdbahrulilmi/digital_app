@php
    $asset = $product->decoded_asset ?? null;
@endphp

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $product->title }}</h1>

    @if($asset)
        <div class="mt-4">
            {{-- JIKA TIPE LINK (Contoh ID 1) --}}
            @if(($asset['type'] ?? '') === 'link')
                <img src="{{ $asset['url'] }}" class="w-full rounded-xl shadow-lg" alt="Image">

            {{-- JIKA TIPE UPLOAD/FILE (Contoh ID 2) --}}
            @else
                @php
                    $filePath = $asset['path'] ?? '';
                    $extension = strtolower($asset['type'] ?? pathinfo($filePath, PATHINFO_EXTENSION));
                    $fullUrl = asset('storage/' . $filePath);
                @endphp

                {{-- Tampilan PDF --}}
                @if($extension === 'pdf')
                    <iframe src="{{ $fullUrl }}" class="w-full h-[600px] rounded-xl" frameborder="0"></iframe>
                
                {{-- Tampilan Gambar --}}
                @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                    <img src="{{ $fullUrl }}" class="w-full rounded-xl" alt="Image">
                
                {{-- Tampilan Video --}}
                @elseif(in_array($extension, ['mp4', 'mov']))
                    <video controls class="w-full rounded-xl"><source src="{{ $fullUrl }}" type="video/{{ $extension }}"></video>
                @endif
            @endif
        </div>
    @else
        <p>Asset tidak ditemukan.</p>
    @endif
</div>  