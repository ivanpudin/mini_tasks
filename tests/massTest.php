<?php

use PHPUnit\Framework\TestCase;

require_once 'src/task1/massConvertor.php';
require_once 'src/bootstrap.php';

class massTest extends TestCase
{
    public function testMassConvertKgToGrams()
    {
        $convertor = new massConvertor();
        $unit1 = 'kg';
        $unit2 = 'grams';
        $quantity = 150;
        $expectedResult = 150000;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testMassConvertKgToPound()
    {
        $convertor = new massConvertor();
        $unit1 = 'kg';
        $unit2 = 'lb';
        $quantity = 1.5;
        $expectedResult = 3.31;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testMassConvertGramsToKilograms()
    {
        $convertor = new massConvertor();
        $unit1 = 'grams';
        $unit2 = 'kg';
        $quantity = 1234;
        $expectedResult = 1.23;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }
    public function testMassConvertGramsToPounds()
    {
        $convertor = new massConvertor();
        $unit1 = 'grams';
        $unit2 = 'lb';
        $quantity = 2575;
        $expectedResult = 5.68;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testMassConvertPoundsToGrams()
    {
        $convertor = new massConvertor();
        $unit1 = 'lb';
        $unit2 = 'grams';
        $quantity = 6.62;
        $expectedResult = 3002.78;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }

    public function testMassConvertPoundsToKilograms()
    {
        $convertor = new massConvertor();
        $unit1 = 'lb';
        $unit2 = 'kg';
        $quantity = 33.069;
        $expectedResult = 15;
        $result = $convertor->convert($unit1, $unit2, $quantity);
        $this->assertEquals($expectedResult, $result);
        $this->assertIsFloat($result);
    }
}
