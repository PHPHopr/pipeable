<?php

use function Hopr\Pipeable\Array\filter;
use function Hopr\Pipeable\Array\map;
use function Hopr\Pipeable\Array\reduce;
use function Hopr\Pipeable\String\chunk;
use function Hopr\Pipeable\String\join;
use function Hopr\Pipeable\String\toLower;
use function Hopr\Pipeable\String\toUpper;

require 'vendor/autoload.php';

// Calculate total revenue after discounts for orders over $500
$orders = ['450', '600', '300', '950', '200'];

$apply_tax = fn (int $x): int => $x * 1.2;  // 20% tax
$is_large_order = fn (int $x): bool => $x > 500;  // Filter orders over $500
$total_revenue = fn(int $x, int $prev) => $x + $prev;

$orders
    |> map($apply_tax)
    |> filter($is_large_order)
    |> reduce($total_revenue, 0)
    |> var_dump(...);

// Generate randomized case receipt number
$receipt = 'RECEIPT-2023-12-25-ABC-XYZ';

$receipt
    |> chunk(4)
    |> map(fn (string $ch): string => $ch |> (mt_rand(0,1) ? toUpper(...) : toLower(...)))
    |> join('')
    |> var_dump(...);
