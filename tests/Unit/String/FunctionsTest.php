<?php

use function Hopr\Pipeable\String\asort;
use function Hopr\Pipeable\String\chunk;
use function Hopr\Pipeable\String\contains;
use function Hopr\Pipeable\String\count;
use function Hopr\Pipeable\String\filter;
use function Hopr\Pipeable\String\first;
use function Hopr\Pipeable\String\join;
use function Hopr\Pipeable\String\last;
use function Hopr\Pipeable\String\map;
use function Hopr\Pipeable\String\reduce;
use function Hopr\Pipeable\String\replace;
use function Hopr\Pipeable\String\reverse;
use function Hopr\Pipeable\String\shuffle;
use function Hopr\Pipeable\String\slice;
use function Hopr\Pipeable\String\sort;
use function Hopr\Pipeable\String\split;
use function Hopr\Pipeable\String\toLower;
use function Hopr\Pipeable\String\toUpper;
use function Hopr\Pipeable\String\trim;
use function Hopr\Pipeable\String\unique;
use function Hopr\Pipeable\String\values;

it('maps over a string', function () {
    $mapFn = map(fn($c) => $c . $c);
    expect($mapFn('abc'))->toBe('aabbcc');
});

it('filters a string', function () {
    $filterFn = filter(fn($c) => $c !== 'b');
    expect($filterFn('abc'))->toBe('ac');
});

it('joins an array', function () {
    $joinFn = join('-');
    expect($joinFn(['a', 'b', 'c']))->toBe('a-b-c');
});

it('reduces a string', function () {
    $reduceFn = reduce(fn($c, $i) => $c . $i, '');
    expect($reduceFn('abc'))->toBe('abc');
});

it('gets the first character of a string', function () {
    expect(first('abc'))->toBe('a');
    expect(first(''))->toBe('');
});

it('gets the last character of a string', function () {
    expect(last('abc'))->toBe('c');
    expect(last(''))->toBe('');
});

it('reverses a string', function () {
    expect(reverse('abc'))->toBe('cba');
});

it('makes a string unique', function () {
    expect(unique('abacaba'))->toBe('abc');
});

it('slices a string', function () {
    $sliceFn = slice(1, 2);
    expect($sliceFn('abcde'))->toBe('bc');
});

it('sorts a string', function () {
    expect(sort('bac'))->toBe('abc');
});

it('sorts a string with asort', function () {
    expect(asort('bac'))->toBe('abc');
});

it('shuffles a string', function () {
    $shuffled = shuffle('abcde');
    expect($shuffled)->not->toBe('abcde');
    expect(strlen($shuffled))->toBe(5);
});

it('counts a string', function () {
    expect(count('abc'))->toBe(3);
});

it('checks if a string contains a value', function () {
    $containsFn = contains('b');
    expect($containsFn('abc'))->toBeTrue();
    $containsFn = contains('d');
    expect($containsFn('abc'))->toBeFalse();
});

it('gets the values of a string', function () {
    expect(values('abc'))->toBe(['a', 'b', 'c']);
});

it('converts a string to uppercase', function () {
    expect(toUpper('abc'))->toBe('ABC');
});

it('converts a string to lowercase', function () {
    expect(toLower('ABC'))->toBe('abc');
});

it('trims a string', function () {
    expect(trim(' a b c '))->toBe('a b c');
});

it('replaces a string', function () {
    $replaceFn = replace('b', 'd');
    expect($replaceFn('abc'))->toBe('adc');
});

it('chunks a string', function () {
    $chunkFn = chunk(2);
    expect($chunkFn('abcde'))->toBe(['ab', 'cd', 'e']);
});

it('splits a string', function () {
    $splitFn = split('-');
    expect($splitFn('a-b-c'))->toBe(['a', 'b', 'c']);
});
