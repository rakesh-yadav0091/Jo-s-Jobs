<?php
require_once __DIR__ . '/TestHelper.php';
require_once __DIR__ . '/../src/Calculator.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->add(2, 3));
        $this->assertEquals(10, $calc->add(5, 5));
        $this->assertEquals(0, $calc->add(-2, 2));
    }

    public function testSubtract()
    {
        $calc = new Calculator();
        $this->assertEquals(2, $calc->subtract(5, 3));
        $this->assertEquals(-2, $calc->subtract(3, 5));
    }

    public function testMultiply()
    {
        $calc = new Calculator();
        $this->assertEquals(15, $calc->multiply(3, 5));
        $this->assertEquals(0, $calc->multiply(5, 0));
    }

    public function testDivide()
    {
        $calc = new Calculator();
        $this->assertEquals(3, $calc->divide(15, 5));
        $this->assertEquals(2.5, $calc->divide(5, 2));
    }

    public function testDivideByZeroThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $calc = new Calculator();
        $calc->divide(10, 0);
    }
}