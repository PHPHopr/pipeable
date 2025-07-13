<?php

use function Hopr\Pipeable\Array\asort;
use function Hopr\Pipeable\Array\contains;
use function Hopr\Pipeable\Array\count;
use function Hopr\Pipeable\Array\filter;
use function Hopr\Pipeable\Array\first;
use function Hopr\Pipeable\Array\hasKey;
use function Hopr\Pipeable\Array\keys;
use function Hopr\Pipeable\Array\last;
use function Hopr\Pipeable\Array\map;
use function Hopr\Pipeable\Array\reduce;
use function Hopr\Pipeable\Array\reverse;
use function Hopr\Pipeable\Array\shuffle;
use function Hopr\Pipeable\Array\slice;
use function Hopr\Pipeable\Array\sort;
use function Hopr\Pipeable\Array\unique;
use function Hopr\Pipeable\Array\values;

it('maps over an array', function () {
    $mapFn = map(fn($i) => $i * 2);
    expect($mapFn([1, 2, 3]))->toBe([2, 4, 6]);
});

it('filters an array', function () {
    $filterFn = filter(fn($i) => ($i % 2) === 0);
    expect($filterFn([1, 2, 3, 4]))->toBe([1 => 2, 3 => 4]);
});

it('reduces an array', function () {
    $reduceFn = reduce(fn($c, $i) => $c + $i, 0);
    expect($reduceFn([1, 2, 3, 4]))->toBe(10);
});

it('gets the first element of an array', function () {
    $firstFn = first();
    expect($firstFn([1, 2, 3]))->toBe(1);
    expect($firstFn([]))->toBeNull();
});

it('gets the last element of an array', function () {
    $lastFn = last();
    expect($lastFn([1, 2, 3]))->toBe(3);
    expect($lastFn([]))->toBeNull();
});

it('reverses an array', function () {
    $reverseFn = reverse();
    expect($reverseFn([1, 2, 3]))->toBe([3, 2, 1]);
});

it('makes an array unique', function () {
    $uniqueFn = unique();
    expect($uniqueFn([1, 2, 2, 3, 1]))->toBe([0 => 1, 1 => 2, 3 => 3]);
});

it('slices an array', function () {
    $sliceFn = slice(1, 2);
    expect($sliceFn([1, 2, 3, 4]))->toBe([2, 3]);
});

it('sorts an array', function () {
    $sortFn = sort();
    expect($sortFn([3, 1, 2]))->toBe([1, 2, 3]);
});

it('sorts an array with asort', function () {
    $asortFn = asort();
    $sorted = $asortFn(['c' => 3, 'a' => 1, 'b' => 2]);
    expect($sorted)->toBe(['a' => 1, 'b' => 2, 'c' => 3]);
});

it('shuffles an array', function () {
    $shuffleFn = shuffle();
    $shuffled = $shuffleFn([1, 2, 3, 4, 5]);
    expect($shuffled)->not->toBe([1, 2, 3, 4, 5]);
    expect(\count($shuffled))->toBe(5);
});

it('counts an array', function () {
    $countFn = count();
    expect($countFn([1, 2, 3]))->toBe(3);
});

it('checks if an array contains a value', function () {
    $containsFn = contains(2);
    expect($containsFn([1, 2, 3]))->toBeTrue();
    $containsFn = contains(4);
    expect($containsFn([1, 2, 3]))->toBeFalse();
});

it('checks if an array has a key', function () {
    $hasKeyFn = hasKey('a');
    expect($hasKeyFn(['a' => 1, 'b' => 2]))->toBeTrue();
    $hasKeyFn = hasKey('c');
    expect($hasKeyFn(['a' => 1, 'b' => 2]))->toBeFalse();
});

it('gets the values of an array', function () {
    $valuesFn = values();
    expect($valuesFn(['a' => 1, 'b' => 2]))->toBe([1, 2]);
});

it('gets the keys of an array', function () {
    $keysFn = keys();
    expect($keysFn(['a' => 1, 'b' => 2]))->toBe(['a', 'b']);
});
