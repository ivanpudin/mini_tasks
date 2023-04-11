<?php declare (strict_types = 1)?>
<?php

class speedConvertor
{
    public function convert(string $first, string $second, float $amount): float
    {
        switch (true) {
            case ($first == 'kph' && $second == 'mps'):
                return round($amount / 3.6, 2);
            case ($first == 'kph' && $second == 'knots'):
                return round($amount / 1.852, 2);
            case ($first == 'mps' && $second == 'kph'):
                return round($amount * 3.6, 2);
            case ($first == 'mps' && $second == 'knots'):
                return round($amount * 1.944, 2);
            case ($first == 'knots' && $second == 'kph'):
                return round($amount * 1.852, 2);
            case ($first == 'knots' && $second == 'mps'):
                return round($amount / 1.944, 2);
            default:
                die(`You have chosen the wrong units: {$first} cannot be converted to {$second}.`);
        }
    }
}
