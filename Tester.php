<?php

class Tester
{
    private Solution $SOLUTION_CLASS;

    public function __construct(Solution $solution) 
    {
        $this->SOLUTION_CLASS = $solution;
    }

    public function test(string $tests_dir)
    {
        $test_inputs = glob($tests_dir . '/*.dat');

        foreach ($test_inputs as $file) {
            $ans_file = str_replace('.dat', '.ans', $file);
            if (file_exists($ans_file)) {
                $test_answer = file($ans_file, FILE_IGNORE_NEW_LINES);
                $solution_answer = $this->SOLUTION_CLASS->solve($file);

                if (count($test_answer) == 1) {
                    $test_answer = $test_answer[0];
                } 

                if ($solution_answer == $test_answer) {
                    echo "+ Test " . pathinfo($file, PATHINFO_FILENAME) . " passed.";
                } else {
                    echo "X Test " . pathinfo($file, PATHINFO_FILENAME) . " failed.";
                    return;
                }
            }
        }
        echo "\n All tests passed!";
    }
}