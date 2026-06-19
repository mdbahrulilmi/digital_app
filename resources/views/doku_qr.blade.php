<!DOCTYPE html>
<html>
<body style="text-align: center; font-family: sans-serif; margin-top: 50px;">
    <h1>Silakan Scan QRIS</h1>
    <p>Invoice: {{ $ref }}</p>
    <p>Total: Rp {{ $amount }}</p>
    
    <div>
        {!! $qrSvg !!}
    </div>
    
    <p style="color: red;">*QR Code ini berlaku selama 1 jam.</p>
</body>
</html> 