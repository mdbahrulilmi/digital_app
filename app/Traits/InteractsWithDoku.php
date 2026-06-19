<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait InteractsWithDoku
{
    protected function callDokuApi(string $endpoint, array $body, string $externalId)
    {
        $accessToken = $this->getDokuAccessToken();
        $timestamp = now('Asia/Jakarta')->format('Y-m-d\TH:i:sP');
        
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $bodyHash = strtolower(hash('sha256', $jsonBody));
        $stringToSign = "POST:{$endpoint}:{$accessToken}:{$bodyHash}:{$timestamp}";
        $signature = base64_encode(hash_hmac('sha512', $stringToSign, env('DOKU_CLIENT_SECRET'), true));

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'X-PARTNER-ID'  => env('DOKU_CLIENT_ID'),
            'X-EXTERNAL-ID' => $externalId,
            'X-TIMESTAMP'   => $timestamp,
            'X-SIGNATURE'   => $signature,
            'CHANNEL-ID'    => 'H2H',
            'Content-Type'  => 'application/json',
        ])->post('https://api-sandbox.doku.com' . $endpoint, $body);

        if ($response->failed()) {
            Log::error('DOKU_API_ERROR', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body()
            ]);
        } else {
            Log::info('DOKU_API_SUCCESS', [
                'endpoint' => $endpoint,
                'response' => $response->json()
            ]);
        }

        return $response;
    }

    private function getDokuAccessToken(): string
    {
        $clientId = env('DOKU_CLIENT_ID');
        $timestamp = now('UTC')->format('Y-m-d\TH:i:s\Z');
        $stringToSign = $clientId . '|' . $timestamp;
        
        $privateKey = file_get_contents(storage_path('app/doku/private.key'));
        openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        
        $response = Http::withHeaders([
            'X-CLIENT-KEY' => $clientId,
            'X-TIMESTAMP'  => $timestamp,
            'X-SIGNATURE'  => base64_encode($signature),
            'Content-Type' => 'application/json',
        ])->post('https://api-sandbox.doku.com/authorization/v1/access-token/b2b', [
            'grantType' => 'client_credentials'
        ]);

        return $response->json('accessToken');
    }
}