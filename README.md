# 🐇 Hopr\Pipeable

A collection of pipeable functions from PHP's standard library, reworked for the pipe operator.
Designed to be straightforward and minimalistic. This repository will not see frequent updates, as it is not intended for continuous development.

## Table of Contents

- [Description](#description)
- [Installation](#installation)
- [Usage](#usage)
  - [Array Functions](#array-functions)
  - [String Functions](#string-functions)
- [Available Functions](#available-functions)
- [Contributing](#contributing)
- [License](#license)

## Description

This library provides a set of functions that can be chained together using the `|> ` operator to create expressive and readable data transformations. It offers utilities for both arrays and strings, allowing for a more functional programming style in PHP.

The pipe operator only allows us to use single-argument functions, which is inconvenient. It forces us to create closures for almost everything. `Hopr\Pipeable` tries to solves this issue.

**Without `Hopr\Pipeable`:**
```php
$arr = [1, 2];
// Assume $filter_function and $reduce_function exist
$filtered = $arr
    |> fn(array $data) => array_filter($data, $filter_function)
    |> fn(array $data) => array_reduce($data, $reduce_function);
```

**With `Hopr\Pipeable`:**
```php
$filtered = $arr
    |> filter($filter_function) 
    |> reduce($reduce_function);
```

Nothing fancy, just straight to the point.

Behind the scenes, `filter` (or `reduce`) are implemented like this:
```php
function filter(callable $callback): callable
{
    return fn(array $array) => array_filter($array, $callback);
}
```
It desugars to the exact equivalent of the example without `Hopr\Pipeable`!
You can also use this library to take advantage of partial application and lazy operations without using the pipe operator.

```php
// Won't be executed until called later !
$extract_user_email = map(fn(User $user) => $user->email);
// Some logic ...
// Executed here
$email = $extract_user_email($current_user);
```

It allows us to have a more *declarative* way of coding.

## Installation

```bash
composer require hopr/pipeable
```

## Usage

### Array Functions

```php
use function Hopr\Pipeable\Array\map;
use function Hopr\Pipeable\Array\filter;
use function Hopr\Pipeable\Array\reduce;

$data = [1, 2, 3, 4, 5];

$result = $data
    |> map(fn($x) => $x * 2)      // [2, 4, 6, 8, 10]
    |> filter(fn($x) => $x > 5)   // [6, 8, 10]
    |> reduce(fn($carry, $item) => $item + $carry, 0); // 24

echo $result; // Output: 24
```

### String Functions

```php
use function Hopr\Pipeable\String\chunk;
use function Hopr\Pipeable\String\map;
use function Hopr\Pipeable\String\join;
use function Hopr\Pipeable\String\toUpper;

$string = "hello world";

$result = $string
    |> chunk(5)               // ["hello", " worl", "d"]
    |> map(fn($x) => $x |> toUpper(...)) // ["HELLO", " WORL", "D"]
    |> join("-");              // "HELLO- WORL-D"

echo $result; // Output: "HELLO- WORL-D"
```

## Available Functions

<details>
<summary>**Array Functions**</summary>

- `map(callable $callback)`: Applies a callback to each element of an array.
- `filter(callable $callback)`: Filters an array using a callback.
- `filter_map(callable $callback)`: Filters and maps an array in a single step.
- `reduce(callable $callback, mixed $initial)`: Reduces an array to a single value.
- `first()`: Gets the first element of an array.
- `last()`: Gets the last element of an array.
- `reverse()`: Reverses the order of elements in an array.
- `unique()`: Removes duplicate values from an array.
- `slice(int $offset, ?int $length = null)`: Extracts a slice of an array.
- `sort()`: Sorts an array.
- `asort()`: Sorts an array and maintains index association.
- `shuffle()`: Shuffles an array.
- `count()`: Counts the number of elements in an array.
- `contains(mixed $value)`: Checks if a value exists in an array.
- `hasKey(mixed $key)`: Checks if a key exists in an array.
- `values()`: Gets all values from an array.
- `keys()`: Gets all keys from an array.

</details>

<details>
<summary>**String Functions**</summary>

- `map(callable $callback, string $separator = '')`: Maps a callable over each character of a string.
- `filter(callable $callback)`: Filters the characters of a string using a callable.
- `join(string|array $with)`: Joins the elements of an array into a string.
- `reduce(callable $callback, mixed $initial)`: Reduces a string to a single value.
- `first()`: Gets the first character of a string.
- `last()`: Gets the last character of a string.
- `reverse()`: Reverses a string.
- `unique()`: Removes duplicate characters from a string.
- `slice(int $offset, ?int $length = null)`: Extracts a substring from a string.
- `sort()`: Sorts the characters of a string alphabetically.
- `asort()`: Sorts the characters of a string alphabetically.
- `shuffle()`: Shuffles the characters of a string randomly.
- `count()`: Gets the length of a string.
- `contains(string $value)`: Checks if a string contains a given value.
- `values()`: Converts a string into an array of characters.
- `toUpper()`: Converts a string to uppercase.
- `toLower()`: Converts a string to lowercase.
- `trim()`: Strips whitespace from the beginning and end of a string.
- `replace(string $search, string $replace)`: Replaces occurrences of a substring within a string.
- `chunk(int $by)`: Chunks a string into parts of a specified size.
- `split(string $delimiter = '', int $chunk_by = 1)`: Splits a string either by a delimiter or into chunks.

</details>

<details>
<summary>**Other Functions**</summary>

- `dump_and_die(mixed $var)`: Dumps a variable and terminates the script.

</details>

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue.

For major changes, please open an issue first to discuss what you would like to change. Please make sure to update tests as appropriate.

## License

This project is licensed under the MIT License.
