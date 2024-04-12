<?php

require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Tester.php');
require('Dijkstra.php');


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

        list($n, $m) = explode(' ', $input[0]);

        $graph = array();
        for ($i = 1; $i < $m + 1; $i++) {
            $line = explode(' ', $input[$i]);
            $graph[$line[0]][$line[1]] = $line[2];
            $graph[$line[1]][$line[0]] = $line[2];
        }
        $answer = array();

        $k = $input[$m + 1];
        for ($i = $m + 2; $i < $m + $k + 2; $i++) {
            list($c, $d, $r) = explode(' ', $input[$i]);
            if ($r == '?') {
                $dijkstra = new Dijkstra($graph);
                $answer[] = $dijkstra->shortestPath($c, $d);
            } else if ($r == -1) {
                unset($graph[$c][$d]);
                unset($graph[$d][$c]);
            } else {
                $graph[$c][$d] = (int)$r;
                $graph[$d][$c] = (int)$r;
            }
        }
        return $answer;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH,
    //one_test: 9
);
