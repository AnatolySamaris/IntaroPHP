<?php

/**
 * Класс для тестирования решений.
 * Тест состоит из двух файлов: N.dat, N.ans, .dat файл содержит вводные данные,
 * .ans файл содержит правильный ответ на соответствующий тест.
 * В конструкторе принимает объект решения с интерфейсом, содержащим метод solve().
 * Позволяет проверить все тесты либо выбрать один конкретный тест.
 */
class Tester
{
    private Solution $SOLUTION_CLASS;

    public function __construct(Solution $solution) 
    {
        $this->SOLUTION_CLASS = $solution;
    }

    public function test(string $tests_dir, int $one_test = 0)
    {
        $test_inputs = glob($tests_dir . '/*.dat');

        if ($one_test > 0) {
            $test_inputs = [$test_inputs[$one_test - 1]];
        }

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
