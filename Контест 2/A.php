<?php

require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Tester.php');


class Solution
{
    public $TESTS_DIR = 'tests/';
    public $TEST_PATH;

    public function __construct()
    {
        $this->TEST_PATH = $this->TESTS_DIR . pathinfo(__FILE__, PATHINFO_FILENAME);
    }

    public function solve(string $file)
    {
        $input = file($file, FILE_IGNORE_NEW_LINES);

        $ad_cnt = array();
        $ad_last_shown = array();

        foreach($input as $line) {
            if ($line) {
                $line = explode("    ", $line);
                $ad = $line[0];
                $timestamp = new DateTime($line[1]);
                if (key_exists($ad, $ad_cnt)) {
                    $ad_cnt[$ad]++;
                    if ($ad_last_shown[$ad] < $timestamp) {
                        $ad_last_shown[$ad] = $timestamp;
                    }
                } else {
                    $ad_cnt[$ad] = 1;
                    $ad_last_shown[$ad] = $timestamp;
                }
            }
        }

        $answer = array();
        $ads = array_keys($ad_cnt);
        foreach($ads as $ad) {
            $answer[] = $ad_cnt[$ad] . " " . $ad . " " . $ad_last_shown[$ad]->format('d.m.Y H:i:s');
        }
        if (count($answer) == 1) {
            $answer = $answer[0];
        }

        return $answer;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH
    //one_test: 1
);
