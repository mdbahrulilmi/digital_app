<?php

namespace App\Services;

use App\Traits\InteractsWithDoku;
use Illuminate\Support\Facades\Log;

class DokuService
{
    use InteractsWithDoku;

    public function createVA($order)
    {
        $vaMapping = [
        'va_mandiri' => ['serviceId' => '  861880', 'channel' => 'VIRTUAL_ACCOUNT_BANK_MANDIRI'],
        'va_cimb'    => ['serviceId' => '   18990', 'channel' => 'VIRTUAL_ACCOUNT_BANK_CIMB'],
        'va_bca'     => ['serviceId' => '  190089', 'channel' => 'VIRTUAL_ACCOUNT_BCA'],
        'va_bni'     => ['serviceId' => '   84923', 'channel' => 'VIRTUAL_ACCOUNT_BNI'],
        'va_bri'     => ['serviceId' => '  139256', 'channel' => 'VIRTUAL_ACCOUNT_BRI'],
        'va_bsi'     => ['serviceId' => '  202020', 'channel' => 'VIRTUAL_ACCOUNT_BSI'],

        ];

        $method = $order->payment_method;
        $config = $vaMapping[$method] ?? null;

        if (!$config) {
            throw new \Exception("Metode pembayaran VA tidak didukung.");
        }

        $partnerServiceId = $config['serviceId'];
        $customerNo = 5; 
        $virtualAccountNo = $partnerServiceId . $customerNo;
        $body = [
            'partnerServiceId' => $partnerServiceId,
            'customerNo' => $customerNo,
            'virtualAccountNo' => $virtualAccountNo,
            'virtualAccountName' => substr($order->customer_name, 0, 30),
            'virtualAccountEmail' => $order->customer_email,
            'virtualAccountPhone' => $order->customer_whatsapp,
            'trxId' => (string) $order->order_id,
            'virtualAccountTrxType' => 'C',
            'expiredDate' => now()->addHours(24)->format('Y-m-d\TH:i:sP'),
            'totalAmount' => [
                'value' => number_format($order->amount, 2, '.', ''),
                'currency' => 'IDR'
                ],
            'additionalInfo' => [
                'channel' => $config['channel'],
                ],
            'freeText' => [
                ['english' => 'Free text', 'indonesia' => 'Tulisan Bebas']
            ]
        ];

        $endpoint = '/virtual-accounts/bi-snap-va/v1.1/transfer-va/create-va';

        return $this->callDokuApi(
            $endpoint,
            $body,
            (string) $order->order_id
        );

    }

    public function createQRIS($order)
    {
        $amountValue = number_format((float)$order->amount, 2, '.', '');

        $body = [
            'partnerReferenceNo' => (string) $order->order_id,
            'amount' => [
                'value' => $amountValue,
                'currency' => 'IDR'
            ],
            'merchantId' => config('doku.merchant_id'),
            'terminalId' => config('doku.terminal_id'),
            'validityPeriod' => now()->addMinutes(30)->format('Y-m-d\TH:i:sP'),
            'additionalInfo' => [
                'postalCode' => '12190',
                'feeType' => '1'
            ]
        ];

        return $this->callDokuApi('/snap-adapter/b2b/v1.0/qr/qr-mpm-generate', $body, (string) $order->order_id);
    }

    public function createEwallet($order, $channel)
    {
        $channels = [
        'dana'      => 'EMONEY_DANA_SNAP',
        'ovo'       => 'EMONEY_OVO_SNAP',
        'shopeepay' => 'EMONEY_SHOPEE_PAY_SNAP'
        ];

        $body = [
            'partnerReferenceNo' => (string) $order->order_id,
            'validUpTo'          => now()->addMinutes(30)->format('Y-m-d\TH:i:sP'),
            'pointOfInitiation'  => 'app',
            'urlParam' => [
                [
                'url'        => 'https://www.digital.sukawebsite.com',
                'type'       => 'PAY_RETURN',
                'isDeepLink' => 'Y'
                ]
            ],
            'amount' => [
                'value'    => number_format((float)$order->amount, 2, '.', ''),
                'currency' => 'IDR'
            ],
            'additionalInfo' => [
                'channel'                    => $channels[$channel] ?? 'EMONEY_DANA_SNAP',
                'orderTitle'                 => 'Order ' . $order->order_id,
                'supportDeepLinkCheckoutUrl' => false
            ]
        ];
        return $this->callDokuApi('/direct-debit/core/v1/debit/payment-host-to-host', $body, (string) $order->order_id);
    }
}