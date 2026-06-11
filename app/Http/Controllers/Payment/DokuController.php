<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DokuController extends Controller
{
    public function getAccessToken()
    {
        $clientId = env('DOKU_CLIENT_ID');

        $timestamp = now('UTC')->format('Y-m-d\TH:i:s\Z');

        $stringToSign = $clientId . '|' . $timestamp;

        $privateKey = file_get_contents(
            storage_path('app/doku/private.key')
        );

        openssl_sign(
            $stringToSign,
            $signature,
            $privateKey,
            OPENSSL_ALGO_SHA256
        );

        $signature = base64_encode($signature);

        $response = Http::withHeaders([
            'X-CLIENT-KEY' => $clientId,
            'X-TIMESTAMP' => $timestamp,
            'X-SIGNATURE' => $signature,
            'Content-Type' => 'application/json',
        ])->post(
            'https://api-sandbox.doku.com/authorization/v1/access-token/b2b',
             [
                'grantType' => 'client_credentials'
            ]
        );

        return $response->json('accessToken');
    }

    public function generateQr()
    {
        $endpoint = '/snap-adapter/b2b/v1.0/qr/qr-mpm-generate';

        $accessToken = $this->getAccessToken();
        $clientSecret = env('DOKU_CLIENT_SECRET');
        $partnerId = env('DOKU_CLIENT_ID');

        $timestamp = now('Asia/Jakarta')
            ->format('Y-m-d\TH:i:sP');

        $body = [
            'partnerReferenceNo' => 'INV-' . time(),
            'amount' => [
                'value' => '1000.00',
                'currency' => 'IDR',
            ],
            'merchantId' => env('DOKU_MERCHANT_ID'),
            'terminalId' => env('DOKU_TERMINAL_ID'),
            'validityPeriod' => now('Asia/Jakarta')
                ->addHour()
                ->format('Y-m-d\TH:i:sP'),
            'additionalInfo' => [
                'postalCode' => '12190',
                'feeType' => '1',
            ],
        ];

        // JSON yang akan di-hash
        $bodyJson = json_encode(
            $body,
            JSON_UNESCAPED_SLASHES
        );

        // SHA256 body
        $bodyHash = strtolower(
            hash('sha256', $bodyJson)
        );

        // SNAP Signature
        $stringToSign =
            'POST' . ':' .
            $endpoint . ':' .
            $accessToken . ':' .
            $bodyHash . ':' .
            $timestamp;

        $signature = base64_encode(
            hash_hmac(
                'sha512',
                $stringToSign,
                $clientSecret,
                true
            )
        );

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'X-PARTNER-ID' => $partnerId,
            'X-EXTERNAL-ID' => (string) now()->timestamp . rand(1000, 9999),
            'X-TIMESTAMP' => $timestamp,
            'X-SIGNATURE' => $signature,
            'CHANNEL-ID' => 'H2H',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(
            'https://api-sandbox.doku.com' . $endpoint,
            $body
        );

        return response()->json([
            'request' => [
                'timestamp' => $timestamp,
                'signature' => $signature,
                'body_hash' => $bodyHash,
                'body' => $body,
            ],
            'response' => $response->json(),
        ]);
    }
}