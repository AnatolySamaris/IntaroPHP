<?php

try {
    require(__DIR__.'\..\Tester.php');
} catch (Throwable $e) {
    require(__DIR__.'/../Tester.php');
}


class Solution
{
    public $TESTS_DIR = 'тесты/';
    public $TEST_PATH;

    public function __construct()
    {
        $this->TEST_PATH = $this->TESTS_DIR . pathinfo(__FILE__, PATHINFO_FILENAME);
    }

    public function solve(string $file)
    {
        $input = file($file, FILE_IGNORE_NEW_LINES);
        return;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH,
    //one_test: 1
);
