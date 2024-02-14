<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;
use function Functional\all;
use function Functional\any;
use function Functional\falsePredicate;
use function Functional\truePredicate;

class FunctionalOperatorsTest extends TestCase
{
    private CallableDecorator $truePredicate;
    private CallableDecorator $falsePredicate;

    public function setUp(): void
    {
        parent::setUp();
        $this->truePredicate = new CallableDecorator(truePredicate());
        $this->falsePredicate = new CallableDecorator(falsePredicate());
    }


    /** @test */
    public function all_should_evaluate_the_only_predicate_available__when_true()
    {

        self::assertTrue(all($this->truePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->truePredicate);
    }

    /** @test */
    public function all_should_evaluate_the_only_predicate_available__when_false()
    {

        self::assertFalse(all($this->falsePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->falsePredicate);
    }

    /** @test */
    public function all_should_evaluate_predicates_until_the_first_one_is_false__when_there_is_a_false()
    {

        self::assertFalse(all($this->truePredicate, $this->falsePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->truePredicate);
        $this->assertExpectedNumberOfCalls(1, $this->falsePredicate);
    }

    /** @test */
    public function all_should_evaluate_predicates_until_the_first_one_is_false()
    {

        self::assertTrue(all($this->truePredicate, $this->truePredicate)());

        $this->assertExpectedNumberOfCalls(2, $this->truePredicate);
    }

    /** @test */
    public function after_the_first_false__all_should_short_circuit_and_skip_evaluation_of_the_next_predicates()
    {
        self::assertFalse(all($this->falsePredicate, $this->truePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->falsePredicate);
        $this->assertExpectedNumberOfCalls(0, $this->truePredicate);
    }


    /** @test */
    public function any_should_evaluate_the_only_predicate_available__when_true()
    {

        self::assertTrue(any($this->truePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->truePredicate);
    }

    /** @test */
    public function any_should_evaluate_the_only_predicate_available__when_false()
    {

        self::assertFalse(any($this->falsePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->falsePredicate);
    }

    /** @test */
    public function after_the_first_true__any_should_short_circuit_and_skip_evaluation_of_the_next_predicates()
    {

        self::assertTrue(any($this->truePredicate, $this->truePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->truePredicate); // Not two (2)
    }

    /** @test */
    public function any_should_evaluate_the_predicates_until_one_is_true__case_beginning()
    {

        self::assertTrue(any($this->truePredicate, $this->falsePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->truePredicate);
        $this->assertExpectedNumberOfCalls(0, $this->falsePredicate);
    }

    /** @test */
    public function any_should_evaluate_the_predicates_until_one_is_true__case_end()
    {
        self::assertTrue(any($this->falsePredicate, $this->truePredicate)());

        $this->assertExpectedNumberOfCalls(1, $this->falsePredicate);
        $this->assertExpectedNumberOfCalls(1, $this->truePredicate);
    }

    /**
     * @param int $expected
     * @param CallableDecorator $callableDecorator
     */
    private function assertExpectedNumberOfCalls(int $expected, CallableDecorator $callableDecorator): void
    {
        self::assertEquals($expected, $callableDecorator->calledTimes);
    }
}

class CallableDecorator
{

    public $calledTimes;
    /**
     * @var callable $callable
     */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
        $this->calledTimes = 0;
    }

    public function __invoke()
    {
        $this->calledTimes++;
        return call_user_func($this->callable);
    }
}
