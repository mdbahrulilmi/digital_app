<?php

namespace App\Services;

use App\Traits\InteractsWithDoku;

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

        $endpoint = '/virtual-accounts/bi-snap-va/v1.1/transfer-va/create-va';

        return $this->callDokuApi(
            $endpoint,
            $body,
            (string) $order->order_id
        );

    }

    public function createQRIS($order)
    {
        $body = [
            'orderNumber' => (string) $order->order_id,
            'amount' => (int) $order->amount,
            'feeType' => '0',
        ];

        return $this->callDokuApi('/b2b/v1.0/qr/qr-mpm-generate', $body);
    }
}