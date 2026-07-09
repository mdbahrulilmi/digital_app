<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Services\OrderService;

class DokuWebhookController extends Controller
{
    public function getAccess(Request $request): array
    {

        $clientId = env('DOKU_CLIENT_ID');
        $requestClientId = $request->header('X-CLIENT-KEY');

        if ($requestClientId !== $clientId) {
            abort(403, 'Invalid Client ID');
        }

        $timestamp = now('UTC')->format('Y-m-d\TH:i:s\Z');
        $stringToSign = $clientId . '|' . $timestamp;

        $privateKey = file_get_contents(storage_path('app/doku/private.key'));
        openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        $response = Http::withHeaders([
            'X-CLIENT-KEY' => $clientId,
            'X-TIMESTAMP'  => $timestamp,
            'X-SIGNATURE'  => base64_encode($signature),
            'Content-Type' => 'application/json',
        ])->post(config('doku.base_url') . '/authorization/v1/access-token/b2b', [
            'grantType' => 'client_credentials'
        ]);

        return [
            "responseCode" => "2007300",
            "responseMessage" => "Successful",
            'accessToken' => $response['accessToken'],
            'tokenType'   => $response['tokenType'] ?? 'Bearer',
            'expiresIn'   => $response['expiresIn']
        ];
    }
    

    public function handle(Request $request)
    {
        Log::info('========== DOKU WEBHOOK ==========');

        Log::info('HEADERS', $request->headers->all());

        if ($request->hasHeader('signature')) {

            if (!$this->isValidQrisSignature($request)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $data = $request->json()->all();

            if (($data['transaction']['status'] ?? '') !== 'SUCCESS') {
                return response()->json([
                    'message' => 'Ignored'
                ], 200);
            }

            $orderId = $data['order']['invoice_number'] ?? null;
        }

        else {

            if (!$this->isValidSignature(
                $request,
                $request->header('X-SIGNATURE')
            )) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $data = $request->json()->all();

            $orderId =
                $data['trxId']
                ?? $data['originalPartnerReferenceNo']
                ?? $data['partnerReferenceNo']
                ?? null;
        }

        if (!$orderId) {
            return response()->json([
                'message' => 'Order ID not found'
            ], 400);
        }

        return DB::transaction(function () use ($orderId) {

            $order = Order::where('order_id', $orderId)
                ->lockForUpdate()
                ->first();

            if (!$order) {
                return response()->json([
                    'message' => 'Order not found'
                ], 404);
            }

            if ($order->status === 'paid') {
                return response()->json([
                    'message' => 'Already processed'
                ], 200);
            }

            $order->update([
                'status' => 'paid'
            ]);

            app(OrderService::class)->processSuccessPayment($order);

            return response()->json([
                'message' => 'OK'
            ], 200);
        });
    }
    

    private function isValidSignature(Request $request, string $signature): bool
    {
        $clientSecret = config('doku.client_secret');
        $httpMethod   = $request->method();
        $endpointUrl  = config('doku.webhook');; 
        $timestamp    = $request->header('X-TIMESTAMP');
        $accessToken  = str_replace('Bearer ', '', $request->header('Authorization') ?? '');
        $rawPayload   = $request->getContent();
    
        $minifiedBody = json_encode(json_decode($rawPayload));
        $sha256Body   = hash('sha256', $minifiedBody);
    
        $stringToSign = "{$httpMethod}:{$endpointUrl}:{$accessToken}:{$sha256Body}:{$timestamp}";
    
        $expectedSignature = base64_encode(hash_hmac('sha512', $stringToSign, $clientSecret, true));

        Log::info('SIGN DEBUG', [
            'client_secret' => substr($clientSecret, 0, 8) . '...',
            'method' => $httpMethod,
            'endpoint' => $endpointUrl,
            'timestamp' => $timestamp,
            'access_token' => substr($accessToken, 0, 30),
            'body' => $minifiedBody,
            'sha256' => $sha256Body,
            'string_to_sign' => $stringToSign,
            'expected_signature' => $expectedSignature,
            'received_signature' => $signature,
        ]);
    
        return hash_equals($expectedSignature, $signature);
    }

   private function isValidQrisSignature(Request $request): bool
    {
        $clientSecret = config('doku.client_secret');

        $clientId   = $request->header('Client-Id');
        $requestId  = $request->header('Request-Id');
        $timestamp  = $request->header('Request-Timestamp');

        $receivedSignature = str_replace(
            'HMACSHA256=',
            '',
            trim($request->header('Signature'))
        );

        $endpointUrl = config('doku.webhook');;

        $body = $request->getContent();

        $digest = base64_encode(
            hash('sha256', $body, true)
        );

        $stringToSign =
            "Client-Id:{$clientId}\n" .
            "Request-Id:{$requestId}\n" .
            "Request-Timestamp:{$timestamp}\n" .
            "Request-Target:{$endpointUrl}\n" .
            "Digest:{$digest}";

        $expectedSignature = base64_encode(
            hash_hmac(
                'sha256',
                $stringToSign,
                $clientSecret,
                true
            )
        );

        Log::info('QRIS SIGNATURE', [
            'string_to_sign' => $stringToSign,
            'digest' => $digest,
            'expected' => $expectedSignature,
            'received' => $receivedSignature,
        ]);

        return hash_equals(
            $expectedSignature,
            $receivedSignature
        );
    }
}

