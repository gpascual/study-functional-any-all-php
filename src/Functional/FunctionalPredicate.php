<?php

namespace Functional;

class FunctionalPredicate
{

    public static function filter(callable $callback, ...$arguments)
    {
        return array_values(
            array_filter($arguments, $callback)
        );
    }
}