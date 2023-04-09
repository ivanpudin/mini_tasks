<?php

use PHPUnit\Framework\TestCase;

require_once 'src/task1/speedConvertor.php';
require_once 'src/bootstrap.php';

class speedTest extends TestCase
{
    public function testSpeedConvertKphToMps()
    {
        $convertor = new speedConvertor();
        $unit1 = 'kph';
        $unit2 = 'mps';
        $quantity = 1;
        $expectedResult = 0.28;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testSpeedConvertKphToKnots()
    {
        $convertor = new speedConvertor();
        $unit1 = 'kph';
        $unit2 = 'knots';
        $quantity = 12;
        $expectedResult = 6.48;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testSpeedConvertMpsToKph()
    {
        $convertor = new speedConvertor();
        $unit1 = 'mps';
        $unit2 = 'kph';
        $quantity = 153;
        $expectedResult = 550.8;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }
    public function testSpeedConvertMpsToKnots()
    {
        $convertor = new speedConvertor();
        $unit1 = 'mps';
        $unit2 = 'knots';
        $quantity = 13;
        $expectedResult = 25.27;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testSpeedConvertKnotsToMps()
    {
        $convertor = new speedConvertor();
        $unit1 = 'knots';
        $unit2 = 'mps';
        $quantity = 28;
        $expectedResult = 14.4;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testSpeedConvertKnotsToKph()
    {
        $convertor = new speedConvertor();
        $unit1 = 'knots';
        $unit2 = 'kph';
        $quantity = 39;
        $expectedResult = 72.23;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }
}
