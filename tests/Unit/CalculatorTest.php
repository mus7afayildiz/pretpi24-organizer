<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Calculator;

class CalculatorTest extends TestCase
{
    public function test_addition()
    {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->add(2, 3));
    }
}
