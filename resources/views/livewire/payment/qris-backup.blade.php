<div>
    <button wire:click="generateQr" class="btn btn-primary">Generate QRIS</button>

    @if($qrUrl)
        <div class="mt-4 text-center">
            <h3>Silahkan Scan QRIS Ini:</h3>
            <!-- Tampilkan gambar QR Code -->
            <img src="{{ $qrUrl }}" alt="QRIS Code" style="width: 300px; height: 300px;">
            <p class="mt-2">Order ID: <strong>{{ $orderId }}</strong></p>
            <p class="text-sm text-gray-500">Gunakan Simulator Midtrans dengan Order ID di atas untuk membayar.</p>
        </div>
    @endif
</div>