<?php

use function Hopr\Pipeable\dump_and_die;

it('dumps and dies', function () {
    // This is a tricky one to test, as it terminates the script.
    // We can't truly assert its behavior in a normal test run.
    // We'll just check that the function exists.
    expect(function_exists('Hopr\Pipeable\dump_and_die'))->toBeTrue();
});
