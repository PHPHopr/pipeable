<?php

namespace Hopr\Pipeable\String;

/**
 * Maps a callable over each character of a string.
 *
 * Note: The $separator parameter is currently unused in the implementation.
 * Characters are always joined using an empty string.
 *
 * @param callable(string): string $callback The callable to apply to each character.
 * @param string $separator This parameter is currently unused.
 * @return callable(string): string A callable that takes a string and returns the mapped string.
 */
function map(callable $callback, string $separator = ''): callable
{
    return fn(string $string) => implode('', array_map($callback, str_split($string)));
}

/**
 * Filters the characters of a string using a callable.
 *
 * Characters for which the callable returns true are kept.
 *
 * @param callable(string): bool $callback The callable used to filter characters.
 * @return callable(string): string A callable that takes a string and returns the filtered string.
 */
function filter(callable $callback): callable
{
    return fn(string $string) => implode('', array_filter(str_split($string), $callback));
}

/**
 * Joins the elements of an array into a string.
 *
 * Note: This function operates on arrays, not strings, and might be misplaced
 * within a string utility namespace.
 *
 * @param string|array $with The separator string or an array of strings to join with.
 * @return callable(array): string A callable that takes an array and returns the joined string.
 */
function join(string|array $with): callable
{
    return fn(array $array): string => implode($with, $array);
}

/**
 * Reduces a string to a single value using a callable and an initial value.
 *
 * The callable is applied to each character of the string.
 *
 * @template T
 * @param callable(T, string): T $callback The callable used for the reduction.
 * @param T $initial The initial value of the accumulator.
 * @return callable(string): T A callable that takes a string and returns the reduced value.
 */
function reduce(callable $callback, mixed $initial): callable
{
    return fn(string $string) => array_reduce(str_split($string), $callback, $initial);
}

/**
 * Gets the first character of a string.
 *
 * @param string $string The input string.
 * @return string The first character, or an empty string if the input is empty.
 */
function first(string $string): string
{
    return $string === '' ? '' : $string[0];
}

/**
 * Gets the last character of a string.
 *
 * @param string $string The input string.
 * @return string The last character, or an empty string if the input is empty.
 */
function last(string $string): string
{
    return $string === '' ? '' : $string[-1];
}

/**
 * Reverses a string.
 *
 * @param string $string The input string.
 * @return string The reversed string.
 */
function reverse(string $string): string
{
    return strrev($string);
}

/**
 * Removes duplicate characters from a string, preserving first-occurrence order.
 *
 * @param string $string The input string.
 * @return string The string with unique characters.
 */
function unique(string $string): string
{
    return implode('', array_unique(str_split($string)));
}

/**
 * Returns a callable that extracts a substring from a string.
 *
 * @param int $offset The starting position.
 * @param int|null $length The maximum length of the returned string.
 * @return callable(string): string A callable that takes a string and returns the substring.
 */
function slice(int $offset, null|int $length = null): callable
{
    return fn(string $string) => substr($string, $offset, $length);
}

/**
 * Sorts the characters of a string alphabetically.
 *
 * @param string $string The input string.
 * @return string The string with sorted characters.
 */
function sort(string $string): string
{
    $chars = str_split($string);
    \sort($chars);
    return implode('', $chars);
}

/**
 * Sorts the characters of a string alphabetically (alias for sort for string characters).
 *
 * @param string $string The input string.
 * @return string The string with sorted characters.
 */
function asort(string $string): string
{
    $chars = str_split($string);
    \asort($chars); // asort preserves keys, but for str_split's numeric keys, it's like sort
    return implode('', $chars);
}

/**
 * Shuffles the characters of a string randomly.
 *
 * @param string $string The input string.
 * @return string The shuffled string.
 */
function shuffle(string $string): string
{
    $chars = str_split($string);
    \shuffle($chars);
    return implode('', $chars);
}

/**
 * Gets the length of a string.
 *
 * @param string $string The input string.
 * @return int The length of the string.
 */
function count(string $string): int
{
    return strlen($string);
}

/**
 * Returns a callable that checks if a string contains a given value.
 *
 * @param string $value The value to search for.
 * @return callable(string): bool A callable that takes a string and returns true if it contains the value, false otherwise.
 */
function contains(string $value): callable
{
    return fn(string $string) => str_contains($string, $value);
}

/**
 * Converts a string into an array of characters.
 *
 * @param string $string The input string.
 * @return string[] An array where each element is a character from the string.
 */
function values(string $string): array
{
    return str_split($string);
}

/**
 * Converts a string to uppercase.
 *
 * @param string $string The input string.
 * @return string The uppercase string.
 */
function toUpper(string $string): string
{
    return strtoupper($string);
}

/**
 * Converts a string to lowercase.
 *
 * @param string $string The input string.
 * @return string The lowercase string.
 */
function toLower(string $string): string
{
    return strtolower($string);
}

/**
 * Strips whitespace from the beginning and end of a string.
 *
 * @param string $string The input string.
 * @return string The trimmed string.
 */
function trim(string $string): string
{
    return \trim($string);
}

/**
 * Returns a callable that replaces occurrences of a substring within a string.
 *
 * @param string $search The value to search for.
 * @param string $replace The replacement value.
 * @return callable(string): string A callable that takes a string and returns the string with replacements.
 */
function replace(string $search, string $replace): callable
{
    return fn(string $string) => str_replace($search, $replace, $string);
}

/**
 * Returns a callable that chunks a string into parts of a specified size.
 *
 * This is an alias for split() with a chunk_by parameter.
 *
 * @param int $by The size of each chunk.
 * @return callable(string): string[] A callable that takes a string and returns an array of string chunks.
 */
function chunk(int $by): callable
{
    return split(chunk_by: $by);
}

/**
 * Returns a callable that splits a string either by a delimiter or into chunks.
 *
 * If delimiter is empty or chunk_by is 1, it splits by character chunks.
 * Otherwise, it splits by the delimiter.
 *
 * @param string $delimiter The delimiter to split the string by. Defaults to ''.
 * @param int $chunk_by The size of chunks when splitting by characters. Defaults to 1.
 * @return callable(string): string[] A callable that takes a string and returns an array of strings (parts or chunks).
 */
function split(string $delimiter = '', int $chunk_by = 1): callable
{
    if ($delimiter === '') {
        return fn(string $string) => str_split($string, $chunk_by);
    }

    return fn(string $string) => explode($delimiter, $string);
}
