<?php

namespace LeapYears;

use function Functional\all;
use function Functional\any;
use function Functional\not;

/**
 * Returns the result of a function evaluation for a set of arguments.
 * Then on future function executions with the same set of arguments the result will be returned from an internal cache.
 *
 * @param callable $callback The memoized function
 * @param mixed ...$arguments The arguments to evaluate the function with
 * @return mixed
 */
function memoize(callable $callback, ...$arguments): mixed
{
        static $memoized = [];
        $key = spl_object_hash($callback) . '#'
            . serialize(array_map(
                static fn($argument) => (is_object($argument) && get_class($argument) === \Closure::class)
                    ? 'closure__' . spl_object_hash($argument) # closures are not serializable
                    : $argument,
                $arguments
            ));
        return $memoized[$key]
            ?? ($memoized[$key] = $callback(...$arguments));
}

/**
 * Creates a partial function that doesn't need to get certain arguments anymore when invoked.
 * This is achieved by providing a constant value for some of the arguments.
 *
 * @param callable $callable the original function the partial will be created from
 * @param mixed ...$arguments the arguments' values that will remain constant inside the partial
 * @return callable
 *
 * @link https://en.wikipedia.org/wiki/Partial_function
 * @todo What happens if the arguments you need to fix must remain on the left and not on the right
 */
function partial(callable $callable, ...$arguments): callable
{
    return static fn (...$nonConstantArguments) => $callable(...$nonConstantArguments, ...$arguments);
}

function isDivisible(int $number, int $divisor): bool
{
    return $number % $divisor === 0;
}

function isDivisibleBy(int $divisor): callable
{
    return partial(isDivisible(...), $divisor);
}

function isLastYearOfTheCentury(): callable
{
    return memoize(isDivisibleBy(...), 100);
}

class LeapYears
{
    public function isLeapYear(int $year): bool
    {
        return memoize(
            any(...),
            all(
                isDivisibleBy(4),
                not(isLastYearOfTheCentury())
            ),
            isDivisibleBy(400)
        )($year);
    }
}
