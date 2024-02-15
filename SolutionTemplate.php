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

    /**
     * Пишем решение внутри метода solve.
     * $file_content содержит входные данные построчно в виде массива,
     * где каждый элемент массива - это отдельная строка ввода.
     * Если в ответе требуется ответ в одной строке - просто возвращаем ответ.
     * Если в ответе требуется многострочный ответ - возвращаем массив, где
     * каждый элемент - это отдельная строка вывода.
     * 
     * @param string $file Файл с входными данными
     * @return mixed Вывод ответа в соответствии с условием
     */
    public function solve(string $file)
    {
        $input = file($file, FILE_IGNORE_NEW_LINES);
        return;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH
    //one_test: 1
);
