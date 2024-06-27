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

    function getRandomWeightedElement(array $weightedValues) {
        $rand = mt_rand(1, (int) array_sum($weightedValues));
    
        foreach ($weightedValues as $key => $value) {
          $rand -= $value;
          if ($rand <= 0) {
            return $key;
          }
        }
      }

    public function solve(string $file)
    {
        $input = file($file, FILE_IGNORE_NEW_LINES);

        $ads = array();
        $amount = 0;

        foreach($input as $line) {
            if ($line) {
                $line = explode(" ", $line);
                $ads[$line[0]] = $line[1];
                $amount += $line[1];
            }
        }

        $count_arr = array();

        foreach($ads as $key => $value) {
            $count_arr[$key] = 0;
        }

        $gen_amount = 10 ** 6;
        for ($i = 0; $i < $gen_amount; $i++) {
            $el = $this->getRandomWeightedElement($ads);
            //if (!isset($count_arr[$el])) {
            //    $count_arr[$el] = 0;
            //}
            $count_arr[$el]++;
        }

        $answer = array();

        foreach ($count_arr as $key => $val) {
            $answer[] = $key . " " . $val / $gen_amount;
        }

        var_dump($answer);

        if (count($answer) == 1) {
            $answer = $answer[0];
        }

        return $answer;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test2C(
    tests_dir: $solution->TEST_PATH,
    //one_test: 1
);
