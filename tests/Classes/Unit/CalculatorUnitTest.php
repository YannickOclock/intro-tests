<?php
    namespace Tests\Classes\Unit;

    use App\Classes\Calculator;
    use PHPUnit\Framework\TestCase;

    class CalculatorUnitTest extends TestCase
    {
        public function testAdd()
        {
            $calculator = new Calculator();
            $resultat = $calculator->add(2, 3);
            $this->assertEquals(5, $resultat);
        }
    }

