<?php

namespace App\Services;

class CurrencyService
{
    const RATES = [
        'usd' => [
            'idr' => 0.44
        ]
    ];

    public function convert($amount, $currency_from, $currency_to){
        $rate = 0;
        if (isset(self::RATES[$currency_from])){
            $rate = self::RATES[$currency_from][$currency_to] ?? 0;
        }

        return round( $amount * $rate, 2 );
    }
}

?>