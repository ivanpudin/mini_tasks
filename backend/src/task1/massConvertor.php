<?php declare (strict_types = 1)?>
<?php

class massConvertor
{
    public function convert(string $first, string $second, float $amount): float
    {
        switch (true) {
            case ($first == 'kg' && $second == 'grams'):
                return round($amount * 1000, 2);
            case ($first == 'kg' && $second == 'lb'):
                return round($amount * 2.2046226218488, 2);
            case ($first == 'grams' && $second == 'kg'):
                return round($amount / 1000, 2);
            case ($first == 'grams' && $second == 'lb'):
                return round($amount * 0.00220462262185, 2);
            case ($first == 'lb' && $second == 'kg'):
                return round($amount * 0.45359237, 2);
            case ($first == 'lb' && $second == 'grams'):
                return round($amount * 453.59237, 2);
            default:
                die(`You have chosen the wrong units: {$first} cannot be converted to {$second}.`);
        }
    }
}
