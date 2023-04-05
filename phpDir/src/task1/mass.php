<?php declare (strict_types=1) ?>
<?php 
function massConvertor(string $first, string $second, int $amount) {
  switch (true) {
    case ($first == 'kg' && $second == 'grams'):
        return $amount / 1000;
    case ($first == 'kg' && $second == 'lb'):
        return $amount * 2.2046226218488;
    case ($first == 'grams' && $second == 'kg'):
        return $amount / 1000;
    case ($first == 'grams' && $second == 'lb'):
        return $amount * 0.00220462262185;
    case ($first == 'lb' && $second == 'kg'):
        return $amount * 0.45359237;
    case ($first == 'lb' && $second == 'grams'):
        return $amount * 453.59237;
    default:
        die(`You have chosen the wrong units: {$first} cannot be converted to {$second}.`);
    }
};