<?php

namespace Hopr\Pipeable;

/**
 * Dumps a variable to output and terminates the script execution.
 *
 * @param mixed $var The variable to dump.
 */
function dump_and_die(mixed $var)
{
    var_dump($var);
    die(0);
}
