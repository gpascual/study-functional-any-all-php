<?php

namespace Functional;

class IntOperator
{

    public static function isEven(): callable
    {
        return function (int $i) {
            return $i % 2 === 0;
        };
    }

    public static function multiple_of_(int $divisor): callable
    {
        return function (int $i) use ($divisor) {
            return $i % $divisor === 0;
        };
    }
}