<?php

namespace Hopr\Pipeable\Array;

/**
 * Apply a callback function to each element of an array.
 *
 * Returns a callable that takes an array and returns a new array
 * with the results of applying the callback to each element.
 *
 * @template TValue
 * @template TResult
 * @param callable(TValue): TResult $callback The callback function to apply.
 * @return callable(array<TValue>): array<TResult> A callable that maps an array.
 */
function map(callable $callback): callable
{
    return fn (array $array) => array_map($callback, $array);
}

/**
 * Filter elements of an array using a callback function.
 *
 * Returns a callable that takes an array and returns a new array
 * containing only the elements for which the callback returns true.
 *
 * @template TValue
 * @param callable(TValue): bool $callback The callback function used for filtering.
 * @return callable(array<TValue>): array<TValue> A callable that filters an array.
 */
function filter(callable $callback): callable
{
    return fn (array $array) => array_filter($array, $callback);
}

function filter_map(callable $map_with): callable
{
    return static function (callable &$filter_with) use ($map_with): callable {
        return static function (array $array) use (&$filter_with, &$map_with): array {
            $acc = [];
            foreach($array as $value) {
                if ($filter_with($value)) {
                    $acc[] = $map_with($value);
                }
            }
            return $acc;
        };
    };
}

/**
 * Reduce an array to a single value using a callback function.
 *
 * Returns a callable that takes an array and returns the reduced value.
 *
 * @template TValue
 * @param callable(TValue, TValue): TValue $callback The callback function used for reduction.
 * @param TValue $initial The initial value for the reduction.
 * @return callable(array<TValue>): TValue A callable that reduces an array.
 */
function reduce(callable $callback, mixed $initial): callable
{
    return fn (array $array) => array_reduce($array, $callback, $initial);
}

/**
 * Get the first element of an array.
 *
 * Returns a callable that takes an array and returns its first element,
 * or null if the array is empty.
 *
 * @template TValue
 * @return callable(array<TValue>): TValue|null A callable that gets the first element.
 */
function first(): callable
{
    return fn (array $array) => empty($array) ? null : reset($array);
}

/**
 * Get the last element of an array.
 *
 * Returns a callable that takes an array and returns its last element,
 * or null if the array is empty.
 *
 * @template TValue
 * @return callable(array<TValue>): TValue|null A callable that gets the last element.
 */
function last(): callable
{
    return fn (array $array) => empty($array) ? null : end($array);
}

/**
 * Reverse the order of elements in an array.
 *
 * Returns a callable that takes an array and returns a new array
 * with the elements in reverse order.
 *
 * @template TValue
 * @return callable(array<TValue>): array<TValue> A callable that reverses an array.
 */
function reverse(): callable
{
    return fn (array $array) => array_reverse($array);
}

/**
 * Remove duplicate values from an array.
 *
 * Returns a callable that takes an array and returns a new array
 * containing only unique values.
 *
 * @template TValue
 * @return callable(array<TValue>): array<TValue> A callable that makes an array unique.
 */
function unique(): callable
{
    return fn (array $array) => array_unique($array);
}

/**
 * Extract a slice of an array.
 *
 * Returns a callable that takes an array and returns a new array
 * containing a portion of the original array specified by offset and length.
 *
 * @template TValue
 * @param int $offset The starting offset.
 * @param null|int $length The length of the slice.
 * @return callable(array<TValue>): array<TValue> A callable that slices an array.
 */
function slice(int $offset, null|int $length = null): callable
{
    return fn (array $array) => array_slice($array, $offset, $length);
}

/**
 * Sort an array.
 *
 * Returns a callable that takes an array and returns a new array
 * with elements sorted in ascending order (numerically or alphabetically).
 * Note: This function modifies the array internally before returning it.
 *
 * @template TValue
 * @return callable(array<TValue>): array<TValue> A callable that sorts an array.
 */
function sort(): callable
{
    return function (array $array) {
        \sort($array);
        return $array;
    };
}

/**
 * Sort an array and maintain index association.
 *
 * Returns a callable that takes an array and returns a new array
 * with elements sorted in ascending order while maintaining original keys.
 * Note: This function modifies the array internally before returning it.
 *
 * @template TKey
 * @template TValue
 * @return callable(array<TKey,TValue>): array<TKey,TValue> A callable that sorts an array with index association.
 */
function asort(): callable
{
    return function (array $array) {
        \asort($array);
        return $array;
    };
}

/**
 * Shuffle an array.
 *
 * Returns a callable that takes an array and returns a new array
 * with its elements in a random order.
 * Note: This function modifies the array internally before returning it.
 *
 * @template TValue
 * @return callable(array<TValue>): array<TValue> A callable that shuffles an array.
 */
function shuffle(): callable
{
    return function (array $array) {
        \shuffle($array);
        return $array;
    };
}

/**
 * Count the number of elements in an array.
 *
 * Returns a callable that takes an array and returns the number of elements it contains.
 *
 * @template TValue
 * @return callable(array<TValue>): int A callable that counts array elements.
 */
function count(): callable
{
    return fn (array $array) => \count($array);
}

/**
 * Check if a value exists in an array.
 *
 * Returns a callable that takes an array and returns true if the specified value
 * is found in the array, using strict comparison.
 *
 * @template TValue
 * @param TValue $value The value to search for.
 * @return callable(array<TValue>): bool A callable that checks if an array contains a value.
 */
function contains(mixed $value): callable
{
    return fn (array $array) => in_array($value, $array, true);
}

/**
 * Check if a key exists in an array.
 *
 * Returns a callable that takes an array and returns true if the specified key
 * exists in the array.
 *
 * @template TKey
 * @param TKey $key The key to check for.
 * @return callable(array<TKey,mixed>): bool A callable that checks if an array has a specific key.
 */
function hasKey(mixed $key): callable
{
    return fn (array $array) => array_key_exists($key, $array);
}

/**
 * Get all values from an array.
 *
 * Returns a callable that takes an array and returns a new array
 * containing all the values from the original array.
 *
 * @template TValue
 * @return callable(array<TValue>): array<TValue> A callable that gets array values.
 */
function values(): callable
{
    return fn (array $array) => array_values($array);
}

/**
 * Get all keys from an array.
 *
 * Returns a callable that takes an array and returns a new array
 * containing all the keys from the original array.
 *
 * @template TKey
 * @template TValue
 * @return callable(array<TKey,TValue>): array<TKey> A callable that gets array keys.
 */
function keys(): callable
{
    return fn (array $array) => array_keys($array);
}
