<?php

use PHPUnit\Framework\TestCase;

require_once 'src/task1/temperatureConvertor.php';
require_once 'src/bootstrap.php';

class temperatureTest extends TestCase
{
    public function testTemperatureConvertKelvinToCelsius()
    {
        $convertor = new speedConvertor();
        $unit1 = 'kelvin';
        $unit2 = 'celsius';
        $quantity = 235;
        $expectedResult = -38.15;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testTemperatureConvertKelvinToFahrenheit()
    {
        $convertor = new speedConvertor();
        $unit1 = 'kelvin';
        $unit2 = 'fahrenheit';
        $quantity = 500;
        $expectedResult = 440.33;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testTemperatureConvertCelsiusToKelvin()
    {
        $convertor = new speedConvertor();
        $unit1 = 'celsius';
        $unit2 = 'kelvin';
        $quantity = -13.5;
        $expectedResult = 259.65;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }
    public function testTemperatureConvertCelsiusToFahrenheit()
    {
        $convertor = new speedConvertor();
        $unit1 = 'celsius';
        $unit2 = 'fahrenheit';
        $quantity = 53.5;
        $expectedResult = 128.3;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testTemperatureConvertFahrenheitToCelsius()
    {
        $convertor = new speedConvertor();
        $unit1 = 'fahrenheit';
        $unit2 = 'celsius';
        $quantity = -12.3;
        $expectedResult = -24.61;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testTemperatureConvertFahrenheitToKelvin()
    {
        $convertor = new speedConvertor();
        $unit1 = 'fahrenheit';
        $unit2 = 'kelvin';
        $quantity = 54.2;
        $expectedResult = 285.48;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }
}
