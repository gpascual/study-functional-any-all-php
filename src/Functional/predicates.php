<?php

namespace Functional;

function all(callable ...$predicates): callable
{
    return function (...$arguments) use ($predicates): bool {
        foreach ($predicates as $predicate) {
            if (!$predicate(...$arguments)) {
                return false;
            }
        }

        return true;
    };
}

function any(callable ...$predicates): callable
{
    return function (...$arguments) use ($predicates): bool {
        foreach ($predicates as $predicate) {
            if ($predicate(...$arguments)) {
                return true;
            }
        }

        return false;
    };
}
function not(callable $predicate)
{
    return function (...$arguments) use ($predicate) {
        return !$predicate(...$arguments);
    };
}

function truePredicate(): callable
{
    return static function (): bool {
        return true;
    };
}

function falsePredicate(): callable
{
    return static function (): bool {
        return false;
    };
}
