<?php

/*
Дана строка с целыми числами. Найдите числа, стоящие в кавычках и увеличьте их в два раза.
Пример: из строки 2aaa'3'bbb'4' сделаем строку 2aaa'6'bbb'8'.
*/

function multiplyInts(string $str) : string
{
    $pattern = "/'(-?\d+)'/";
    preg_match_all($pattern, $str, $matches);
    foreach ($matches[1] as $match) {
        $str = str_replace("'".$match."'", "'".($match * 2)."'", $str);
    }
    return $str;
}


// Тестирование функции

$tests = [
    "2aaa'3'bbb'4'" => "2aaa'6'bbb'8'",
    "a123b45 4k" => "a123b45 4k",
    "'12345a10'" => "'12345a10'",
    "'123'" => "'246'",
    "a'0'b'-2'c" => "a'0'b'-4'c",
];

foreach ($tests as $test => $answer) {
    if (multiplyInts($test) == $answer) {
        echo "Ok.\n";
    } else {
        echo "Test $test failed: " . multiplyInts($test) . " is not equal to $answer\n";
        break;
    }
}
