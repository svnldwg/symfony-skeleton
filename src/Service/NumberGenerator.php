<?php

namespace App\Service;

class NumberGenerator
{
    public function random(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
