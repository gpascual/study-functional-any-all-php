<?php

namespace Tests;

use LeapYears\LeapYears;
use PHPUnit\Framework\TestCase;

class LeapYearsTest extends TestCase
{
    private $leapYears;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leapYears = new LeapYears();
    }

    /** @test */
    public function given_a_year__the_last_of_the_century__divisible_by_400__should_return_true(): void
    {
        $year = 2000;

        $result = $this->leapYears->isLeapYear($year);

        self::assertTrue($result);
    }

    /** @test */
    public function given_a_year__the_last_of_the_century__otherwise__should_return_false(): void
    {
        $year = 2100;

        $result = $this->leapYears->isLeapYear($year);

        self::assertFalse($result);
    }

    /** @test */
    public function given_a_year__not_the_last_of_the_century__divisible_by_4__should_return_true(): void
    {
        $year = 2004;

        $result = $this->leapYears->isLeapYear($year);

        self::assertTrue($result);
    }

    /** @test */
    public function given_a_year__otherwise__should_return_false(): void
    {
        $year = 2005;

        $result = $this->leapYears->isLeapYear($year);

        self::assertFalse($result);
    }

    /**
     * @test
     * @dataProvider leapYearsFrom1896To2104Provider()
     */
    public function given_a_leap_year__from_1896_to_2104__should_return_true(int $leapYear): void
    {
        $result = $this->leapYears->isLeapYear($leapYear);

        self::assertTrue($result);
    }

    public function leapYearsFrom1896To2104Provider(): array
    {
        return [
            [1896],
            [1904],
            [1908],
            [1912],
            [1916],
            [1920],
            [1924],
            [1928],
            [1932],
            [1936],
            [1940],
            [1944],
            [1948],
            [1952],
            [1956],
            [1960],
            [1964],
            [1968],
            [1972],
            [1976],
            [1980],
            [1984],
            [1988],
            [1992],
            [1996],
            [2000],
            [2004],
            [2008],
            [2012],
            [2016],
            [2020],
            [2024],
            [2028],
            [2032],
            [2036],
            [2040],
            [2044],
            [2048],
            [2052],
            [2056],
            [2060],
            [2064],
            [2068],
            [2072],
            [2076],
            [2080],
            [2084],
            [2088],
            [2092],
            [2096],
            [2104],
        ];
    }
}
