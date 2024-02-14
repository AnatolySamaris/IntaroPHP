<?php

try {
    require(__DIR__.'\..\Tester.php');
} catch (Throwable $e) {
    require(__DIR__.'/../Tester.php');
}


// Складываем победившие ставки, умноженные на соответствующие коэффициенты,
// и вычитаем сумму поставленных денег.
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

        $n = (int)$input[0];
        $bets = [];
        $sumOfBets = 0;
        for ($i = 1; $i < $n + 1; $i++) {
            $line = explode(' ', $input[$i]);
            $bets[$line[0]] = [$line[1], $line[2]];
            $sumOfBets += $line[1];
        }

        $m = (int)$input[$n + 1];

        $win = 0;
        for ($i = $n + 1; $i < $n + $m + 2; $i++) {
            $line = explode(' ', $input[$i]);
            if (isset($line[4]) && 
                array_key_exists($line[0], $bets) && 
                $line[4] == $bets[$line[0]][1]) {
                    switch ($line[4]) {
                        case 'L':
                            $win += (float)$line[1] * (int)$bets[$line[0]][0];
                            break;
                        case 'R':
                            $win += (float)$line[2] * (int)$bets[$line[0]][0];
                            break;
                        case 'D':
                            $win += (float)$line[3] * (int)$bets[$line[0]][0];
                            break;
                    }
            }
        }

        $result = $win - $sumOfBets;

        return $result;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH,
    //one_test: 8
);
