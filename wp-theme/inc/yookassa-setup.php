<?php
/**
 * YooKassa integration instructions and setup helper.
 *
 * Install plugin: wordpress.org/plugins/yookassa
 * Then add Shop ID and Secret Key in WooCommerce → Settings → Payments → ЮКасса
 */

defined('ABSPATH') || exit;

// Force ЮКасса to top of payment methods list
add_filter('woocommerce_available_payment_gateways', function($gateways) {
    if (isset($gateways['yookassa'])) {
        $yoo = $gateways['yookassa'];
        unset($gateways['yookassa']);
        $gateways = ['yookassa' => $yoo] + $gateways;
    }
    return $gateways;
});

// Add ЮКасса receipt data (54-ФЗ) — tax system
add_filter('woocommerce_yookassa_create_payment_data', function($data, $order) {
    $data['receipt'] = [
        'customer' => [
            'email' => $order->get_billing_email(),
            'phone' => preg_replace('/\D/', '', $order->get_billing_phone()),
        ],
        'tax_system_code' => 1, // ОСН — change to match your tax system
        'items' => [],
    ];

    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        $data['receipt']['items'][] = [
            'description'     => $product->get_name(),
            'quantity'        => $item->get_quantity(),
            'amount'          => [
                'value'    => number_format($item->get_total() / $item->get_quantity(), 2, '.', ''),
                'currency' => 'RUB',
            ],
            'vat_code'        => 1, // Без НДС
            'payment_subject' => 'commodity',
            'payment_mode'    => 'full_payment',
        ];
    }

    // Delivery
    if ($order->get_shipping_total() > 0) {
        $data['receipt']['items'][] = [
            'description'     => 'Доставка',
            'quantity'        => 1,
            'amount'          => [
                'value'    => number_format($order->get_shipping_total(), 2, '.', ''),
                'currency' => 'RUB',
            ],
            'vat_code'        => 1,
            'payment_subject' => 'service',
            'payment_mode'    => 'full_payment',
        ];
    }

    return $data;
}, 10, 2);
