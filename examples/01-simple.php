<?php

use function Hopr\Pipeable\Array\filter;
use function Hopr\Pipeable\Array\filter_map;
use function Hopr\Pipeable\Array\map;
use function Hopr\Pipeable\Array\reduce;
use function Hopr\Pipeable\String\chunk;
use function Hopr\Pipeable\String\join;
use function Hopr\Pipeable\String\toLower;
use function Hopr\Pipeable\String\toUpper;

require 'vendor/autoload.php';

$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$arr_str = ['1', '2', '3', '4', '5'];

$double = fn (int $x): int => $x * 2;
$over_five = fn (int $x): bool => $x > 5;
$sum = fn(int $x, int $prev) => $x + $prev;

$arr_str
    |> map($double)
    |> filter($over_five)
    |> reduce($sum, 0)
    |> var_dump(...);

$str = 'Hello, World! How are you doing today ?';

$str
    |> chunk(4)
    |> map(fn (string $ch): string => $ch |> (mt_rand(0,1) ? toUpper(...) : toLower(...)) )
    // |> filter(fn (string $word) => strlen($word) > 5)
    // |> reverse()
    |> join('')
    |> var_dump(...);


$arr = range(1, 1_000_000);
$over_five = fn (int $x): bool => $x > 500_000;

echo "Loop based\n";
$start = microtime(true);
$acc = [];
foreach($arr as $value) {
    if ($value < 500_000) {
        continue;
    }
    $acc[] = $value * 2;
}
$end = microtime(true);
echo "Time: " . ($end - $start) . " seconds\n\n";
gc_collect_cycles();
echo "filter and map\n";
$start = microtime(true);
$arr |> filter($over_five) |> map($double);
$end = microtime(true);
echo "Time: " . ($end - $start) . " seconds\n\n";

gc_collect_cycles();
echo "filter_map\n";
$start = microtime(true);
$filter_mapped = filter_map($double)($over_five);
$arr |> $filter_mapped(...);
$end = microtime(true);
echo "Time: " . ($end - $start) . " seconds\n";
gc_collect_cycles();
