<?php

require('../Tester.php');


class Solution
{
    public $TESTS_DIR = 'тесты/';
    public $TEST_PATH = $TESTS_DIR . pathinfo(__FILE__, PATHINFO_FILENAME);

    public function solve(string $file)
    {
        $file_content = file($file);
        return;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    $solution->TEST_PATH
);
