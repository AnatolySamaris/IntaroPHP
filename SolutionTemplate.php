<?php

require('Tester.php');


class Solution
{
    public $TESTS_DIR = 'tests/';
    public $TEST_PATH = $TESTS_DIR . pathinfo(__FILE__, PATHINFO_FILENAME);

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
        $file_content = file($file);
        return;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    $solution->TEST_PATH
);
