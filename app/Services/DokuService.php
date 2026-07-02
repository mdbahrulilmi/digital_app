<?php

namespace App\Services;

use App\Traits\InteractsWithDoku;
use Illuminate\Support\Facades\Log;

class DokuService
{
    use InteractsWithDoku;

    public function createVA($order)
    {
        $serviceIds = 
        app()->environment('production')
        ? [
            'va_bca'     => '   19008',
            'va_bni'     => '98829172',
            'va_bri'     => '   13925',
            'va_bsi'     => '   60599',
            'va_mandiri' => '   86188',
        ]
        : 
        [
            'va_mandiri' => '  861880',
            'va_bca'     => '  190089',
            'va_bni'     => '   84923',
            'va_bri'     => '  139256',
            'va_bsi'     => '  202020',
        ];

        $channels = [
            'va_mandiri' => 'VIRTUAL_ACCOUNT_BANK_MANDIRI',
            'va_bca'     => 'VIRTUAL_ACCOUNT_BCA',
            'va_bni'     => 'VIRTUAL_ACCOUNT_BNI',
            'va_bri'     => 'VIRTUAL_ACCOUNT_BRI',
            'va_bsi'     => 'VIRTUAL_ACCOUNT_BSI',
        ];

        $method = $order->payment_method;

        $config = [
            'serviceId' => $serviceIds[$method] ?? null,
            'channel'   => $channels[$method] ?? null,
        ];

        
        if (!$config['serviceId'] || !$config['channel']) {
            throw new \Exception("Metode pembayaran VA tidak didukung.");
            }
            
        if (!$config) {
            throw new \Exception("Metode pembayaran VA tidak didukung.");
            }
                
        $settlement = [
            [
                'bank_account_settlement_id' => config('doku.bank_settlement_id') ?? '',
                "value" => 100,
                "type" => "PERCENTAGE"
            ],
        ];

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
                'settlement' => $settlement
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
                'url'        => 'https://www.digital.sukawebsite.com/payment?order_id='. (string) $order->order_id . '&method=' . $channel,
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