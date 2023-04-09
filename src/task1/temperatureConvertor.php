<?php declare (strict_types = 1)?>
<?php

class temperatureConvertor
{
    public function convert(string $first, string $second, float $amount): float
    {

        switch (true) {
            case ($first == 'celsius' && $second == 'fahrenheit'):
                return round ($amount * 9/5) + 32;
            case ($first == 'celsius' && $second == 'kelvin'):
                return round ($amount + 273.15);
            case ($first == 'fahrenheit' && $second == 'celsius'):
                return round ($amount - 32) * 5/9;
            case ($first == 'fahrenheit' && $second == 'kelvin'):
                return round ($amount + 459.67) * 5/9;
            case ($first == 'kelvin' && $second == 'celsius'):
                return round ($amount - 273.15);
            case ($first == 'kelvin' && $second == 'fahrenheit'):
                return round (($amount * 9/5) - 459.67);
            default:
                die(`You have chosen the wrong units: {$first} cannot be converted to {$second}.`);
        }
    }    
}
?>
