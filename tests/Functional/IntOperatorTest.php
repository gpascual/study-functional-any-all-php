<?php

namespace Tests\Functional;

use Functional\IntOperator as Int_;
use PHPUnit\Framework\TestCase;
use function Functional\all;
use function Functional\any;
use function Functional\not;
use function Functional\truePredicate;

class IntOperatorTest extends TestCase
{

    /** @test */
    public function all_should_evaluate_the_only_predicate_available__when_true()
    {
        $even = all(Int_::isEven());
        self::assertEquals([2, 4, 6], \Functional\FunctionalPredicate::filter($even, 2, 4, 6));
        self::assertEquals([2, 4, 6], \Functional\FunctionalPredicate::filter($even, 2, 4, 6, 7));
    }

    /** @test */
    public function any__when_the_second_predicate_is_more_inclusive__then_the_result_is_always_equivalent()
    {
        $all_elements = any(Int_::isEven(), truePredicate());
        self::assertEquals([7, 2, 4, 6, 9], \Functional\FunctionalPredicate::filter($all_elements, 7, 2, 4, 6, 9));

        $all_elements = any(truePredicate());
        self::assertEquals([7, 2, 4, 6, 9], \Functional\FunctionalPredicate::filter($all_elements, 7, 2, 4, 6, 9));
    }

    /** @test */
    public function find_multiple_of_4_Not_100()
    {
        $expected = [2012, 2016, 2020, 2024, 2028, 2032, 2036];

        $x = all(Int_::isEven(), Int_::multiple_of_(4), not(Int_::multiple_of_(100)));

        self::assertEquals($expected, \Functional\FunctionalPredicate::filter($x, ...range(2010, 2038)));

    }

    /** @test */
    public function find_leap_years()
    {
        $expected = [1896, 1904, 1908, 1912, 1916, 1920, 1924, 1928, 1932, 1936, 1940, 1944, 1948, 1952, 1956, 1960, 1964, 1968, 1972, 1976, 1980, 1984, 1988, 1992, 1996, 2000, 2004, 2008, 2012, 2016, 2020, 2024, 2028, 2032, 2036, 2040, 2044, 2048, 2052, 2056, 2060, 2064, 2068, 2072, 2076, 2080, 2084, 2088, 2092, 2096, 2104];

        $leapYearFinder = any(
            Int_::multiple_of_(400),
            all(Int_::isEven(), Int_::multiple_of_(4), not(Int_::multiple_of_(100))));

        self::assertEquals($expected, \Functional\FunctionalPredicate::filter($leapYearFinder, ...range(1896, 2104)));

    }

}
