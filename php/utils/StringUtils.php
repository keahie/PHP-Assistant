<?php

function str_contains($contains, $search)
{
    return strpos($search, $contains) !== false;
}

function str_validate($string)
{
    $string = str_replace('ß', 'ss', $string);
    $string = strtolower($string);
    $string = substr($string, 1, strlen($string) - 2);
    return $string;
}
