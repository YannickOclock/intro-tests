<?php
    namespace App\Classes;

    class RandomGenerator {
        public function randomInt($min = 0, $max = 10): int
        {
            return random_int($min, $max);
        }
    }