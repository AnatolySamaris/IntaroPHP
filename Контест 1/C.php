<?php

require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Tester.php');


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
        $answer = array();

        foreach ($input as $line) {
            $request = explode('> ', $line);
            $str = trim($request[0], '<');
            $args = explode(' ', $request[1]);
            $type = $args[0];

            if ($type == 'S' or $type == 'N') {
                $n = $args[1];
                $m = $args[2];
            }

            switch ($type) {
                case 'S':
                    $str_len = strlen($str);
                    if ($n <= $str_len && $str_len <= $m) {
                        $answer[] = 'OK';
                    } else {
                        $answer[] = 'FAIL';
                    }
                    break;
                case 'N':
                    if ($n <= $str && $str <= $m && preg_match('/^-?\d+$/', $str)) {
                        $answer[] = 'OK';
                    } else {
                        $answer[] = 'FAIL';
                    }
                    break;
                case 'P':
                    $phone_pattern = '/^\+7 \(\d{3}\) \d{3}\-\d{2}\-\d{2}$/';
                    if (preg_match($phone_pattern, $str)) {
                        $answer[] = 'OK';
                    } else {
                        $answer[] = 'FAIL';
                    }
                    break;
                case 'D':
                    $date_format_1 = 'd.m.Y G:i';
                    $date_format_2 = 'j.n.Y G:i';
                    $date = DateTime::createFromFormat($date_format_1, $str);
                    if (!$date) {
                        $date = DateTime::createFromFormat($date_format_2, $str);
                    }
                    if ($date && 
                        $date->format($date_format_1) == $str || 
                        $date->format($date_format_2) == $str) {
                        $answer[] = 'OK';
                    } else {
                        $answer[] = 'FAIL';
                    }
                    break;
                case 'E':
                    $email_pattern = '/^[a-zA-Z0-9_]{4,30}@[a-zA-Z]{2,30}\.[a-z]{2,10}$/';
                    if (preg_match($email_pattern, $str) && $str[0] != '_') {
                        $answer[] = 'OK';
                    } else {
                        $answer[] = 'FAIL';
                    }
                    break;
            }
        }

        return $answer;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH,
    //one_test: 4
);
