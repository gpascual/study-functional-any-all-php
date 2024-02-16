## 2024-02-16

## Exercises

### Exercise 1

Characterize the class `src/Functional/FunctionalPredicate.php`

For achieving that:
1. Use the `CallableDecorator`. That tool will help you keep count of how many times it has been invoked. Think of it like a mock.
2. Find the basic properties of functions `any`, `all`.

### Exercise 2

Create a small program for finding the leap years (años bisiestos).

In Spanish:
> Año bisiesto es el divisible entre 4, salvo que sea año secular —último de cada siglo, terminado en «00»—, en cuyo caso también ha de ser divisible entre 400.
> https://es.wikipedia.org/wiki/A%C3%B1o_bisiesto

In English:
> Their number is divisible by 4, except the last year of each century (finishing in `00`), in which case it must be divisible by 400.
> https://en.wikipedia.org/wiki/Leap_year

As an oracle for the correct response of leap years between 1896 and 2104 both included:

```php
$expected = [1896, 1904, 1908, 1912, 1916, 1920, 1924, 1928, 1932, 1936, 1940, 1944, 1948, 1952, 1956, 1960, 1964, 1968, 1972, 1976, 1980, 1984, 1988, 1992, 1996, 2000, 2004, 2008, 2012, 2016, 2020, 2024, 2028, 2032, 2036, 2040, 2044, 2048, 2052, 2056, 2060, 2064, 2068, 2072, 2076, 2080, 2084, 2088, 2092, 2096, 2104];
```

For achieving this:
1. Create a class that can perform predicates on `int` (just represent the year as a number)
2. Find the combination of any, all, etc to create the business logic for the leap year

### General Notes

1. The repo contains the solution. Start from the `start/1` branch before checking the proposed solution.
2. The Leap Year is not the goal, it's just a study to practice any, all.
3. Enjoy!

