<?php

namespace App\Classes;

readonly class Calculator
{

    public function add($a, $b)
    {
        return $a + $b;
    }

    public function addWithRandom(RandomGenerator $randomGenerator, $a): int
    {
        return $a + $randomGenerator->randomInt();
    }
}