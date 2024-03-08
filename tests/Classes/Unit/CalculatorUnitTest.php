<?php
    namespace Tests\Classes\Unit;

    use App\Classes\Calculator;
    use App\Classes\RandomGenerator;
    use PHPUnit\Framework\MockObject\Exception;
    use PHPUnit\Framework\TestCase;

    class CalculatorUnitTest extends TestCase
    {
        public function testAdd()
        {
            $calculator = new Calculator();
            $result = $calculator->add(2, 3);
            $this->assertEquals(5, $result);
        }

        /**
         * @throws Exception
         */
        public function testAddWithRandom()
        {
            $randomGenerator = $this->createMock(RandomGenerator::class);
            $randomGenerator->method('randomInt')->willReturn(3);
            $calculator = new Calculator();
            $result = $calculator->addWithRandom($randomGenerator, 2);
            $this->assertEquals(5, $result);
        }
    }

