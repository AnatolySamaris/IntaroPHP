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
            $groups = explode(':', $line);
            $n = count($groups);

            if ($groups[0] == '') {
                array_shift($groups);
                $n--;
            }
            if ($groups[$n-1] == '') {
                array_pop($groups);
                $n--;
            }

            $new_ip = array(); // складываем символы, чтобы потом их слепить - так оптимальнее
            foreach ($groups as $group) {
                if ($group == '') {
                    $new_ip = array_merge(
                        $new_ip,
                        array_fill(
                            0,
                            9 - $n, // 8 - $n + 1
                            '0000'
                        )
                    );
                } else if (strlen($group) < 4) {
                    $new_ip[] = str_pad(
                        string: $group,
                        length: 4,
                        pad_string: '0',
                        pad_type: STR_PAD_LEFT
                    );
                } else {
                    $new_ip[] = $group;
                }
            }
            $answer[] = implode(':', $new_ip);
        }

        return $answer;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH,
    //one_test: 1
);
