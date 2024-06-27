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

        $nodes = array();

        foreach($input as $line) {
            if ($line) {
                $line = explode(" ", $line);
                $id = $line[0];
                $name = $line[1];
                $left = $line[2];
                $right = $line[3];
                $nodes[$id] = array($name, (int)$left, (int)$right);
            }
        }

        // Сортируем по left
        usort($nodes, function($a, $b) {
            return $a[1] - $b[1];
        });

        $stack = array();
        $spaces = array();
        foreach(array_keys($nodes) as $key) {
            // Если стек пустой
            if (!$stack) {
                $spaces[$key] = 0;
                $stack[] = $key;
            }
            // Если left больше чем right конца стека
            else if ($nodes[$key][1] > $nodes[end($stack)][2]) {
                while ($stack && $nodes[$key][1] > $nodes[end($stack)][2]) {
                    array_pop($stack);
                }
                $spaces[$key] = count($stack);
                $stack[] = $key;
            }
            else {
                $spaces[$key] = count($stack);
                $stack[] = $key;
            }
            // Если лист
            if ($nodes[$key][1] + 1 == $nodes[$key][2] && end($stack) == $key) {
                array_pop($stack);
            }
        }

        $answer = array();
        foreach($spaces as $id => $space) {
            $answer[] = str_repeat('-', $space) . $nodes[$id][0];
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
    tests_dir: $solution->TEST_PATH,
    //one_test: 5
);
