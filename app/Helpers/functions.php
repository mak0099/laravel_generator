<?php
function camel_to_snake($input)
{
    if (preg_match('/[A-Z]/', $input) === 0) {
        return $input;
    }
    $pattern = '/([a-z])([A-Z])/';
    $r = strtolower(preg_replace_callback($pattern, function ($a) {
        return $a[1] . "_" . strtolower($a[2]);
    }, $input));
    return $r;
}
