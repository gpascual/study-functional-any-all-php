<?php

namespace Test\Functional;

use Functional\FunctionalPredicate;
use PHPUnit\Framework\TestCase;
use Tests\Functional\CallableDecorator;

use function Functional\all;
use function Functional\falsePredicate;
use function Functional\truePredicate;

class FunctionalAllTest extends TestCase
{
    /**
     * @test
     * @dataProvider callbacksProvider
     */
    public function all__should_return_filtered_elements(array $expected, array $callbacks, array $arguments): void
    {
        $result = FunctionalPredicate::filter(all(...$callbacks), ...$arguments);

        self::assertEquals($expected, $result);
    }

    public function callbacksProvider(): array
    {
        return [
            'given no predicates should keep all elements' => [
                [1, 2, 3, 4, 5],
                [],
                [1, 2, 3, 4, 5],
            ],
            'given some predicates which evaluate elements to false should filter out those elements' => [
                [],
                [falsePredicate(), falsePredicate()],
                [1, 2, 3, 4, 5],
            ],
            'given some predicates which evaluate elements to true and some others which evaluate them to false should filter out those elements' => [
                [],
                [falsePredicate(), truePredicate()],
                [1, 2, 3, 4, 5],
            ],
            'given some predicates which evaluate elements to true should filter keep those elements' => [
                [1, 2, 3, 4, 5],
                [truePredicate(), truePredicate()],
                [1, 2, 3, 4, 5],
            ],
        ];
    }

    /** @test */
    public function given_a_predicate_which_evaluates_elements_to_true_followed_by_another_one__should_invoke_the_following_one_too(): void
    {
        $arguments = [1, 2, 3, 4, 5];
        $truePredicate = new CallableDecorator(truePredicate());
        $anotherPredicate = new CallableDecorator(falsePredicate());

        FunctionalPredicate::filter(
            all(
                $truePredicate,
                $anotherPredicate
            ),
            ...$arguments
        );

        self::assertEquals(5, $truePredicate->calledTimes);
        self::assertEquals(5, $anotherPredicate->calledTimes);
    }

    /** @test */
    public function given_a_predicate_which_evaluates_elements_to_false_followed_by_another_one__should_not_invoke_the_following_one(): void
    {
        $arguments = [1, 2, 3, 4, 5];
        $falsePredicate = new CallableDecorator(falsePredicate());
        $anotherPredicate = new CallableDecorator(falsePredicate());

        FunctionalPredicate::filter(
            all(
                $falsePredicate,
                $anotherPredicate
            ),
            ...$arguments
        );

        self::assertEquals(5, $falsePredicate->calledTimes);
        self::assertEquals(0, $anotherPredicate->calledTimes);
    }
}
