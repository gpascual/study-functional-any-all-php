<?php

namespace Tests\Functional;

use Functional\FunctionalPredicate;
use PHPUnit\Framework\TestCase;

use function Functional\falsePredicate;
use function Functional\truePredicate;

class FunctionalPredicateTest extends TestCase
{
    /**
     * @test
     * @dataProvider predicatesDataProvider
     */
    public function given_any_variadic_arguments__should_return_a_filtered_list_from_them(
        array $expected,
        callable $callback,
        $arguments
    ): void {
        $result = FunctionalPredicate::filter($callback, ...$arguments);

        self::assertEquals($expected, $result);
    }

    /** @test */
    public function given_n_variadic_arguments__should_invoke_the_callback_n_times(): void
    {
        $callback = new CallableDecorator(truePredicate());
        $arguments = ['a', 'b', 'c', 'd', 'e', 'f'];

        FunctionalPredicate::filter($callback, ...$arguments);

        self::assertEquals(count($arguments), $callback->calledTimes);
    }

    public function predicatesDataProvider(): array
    {
        return [
            'given a predicate which evaluates elements to true, should keep those elements'
                => [[1, 1], truePredicate(), [1, 1],],
            'given a predicate which evaluates elements to false, should filter out those elements'
                => [[], falsePredicate(), [2, 2],],
        ];
    }
}
