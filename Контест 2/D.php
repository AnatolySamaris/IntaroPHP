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

    private function compressStyles(string $code, string $style) {
        $pattern = '/' . $style . '-(top|right|bottom|left):\s*([^;}\s]+)[;}]?/';
        $res = [];
        preg_match_all($pattern, $code, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $res[$match[1]] = $match[2];    // Записываем в формате 'top' => '2px' и тд
        }
        if (isset($res['top'], $res['right'], $res['bottom'], $res['left'])) {
            $replace = "{$style}:{$res['top']} {$res['right']} {$res['bottom']} {$res['left']};";
            $code = preg_replace($pattern, '', $code);    // Удаляем старые свойства
            $code .= $replace;
        }
        return $code;
    }

    public function solve(string $file)
    {
        $input = file($file, FILE_IGNORE_NEW_LINES);

        $code = '';

        foreach($input as $line) {
            if ($line) {
                $code .= $line;
            }
        }

        // Удаляем комментарии
        $code = preg_replace(
            '/\/\*.*?\*\//s',
            '',
            $code
        );

        // Убираем пробелы, меняем значения цветов
        $code = str_replace(
            [' ', '#CD853F', '#FFC0CB', '#DDA0DD', '#FF0000', '#FFFAFA', '#D2B48C'],
            ['',  'peru',    'pink',    'plum',    'red',     'snow',    'tan'],
            $code
        );

        // Сокращаем цветовые коды
        $code = preg_replace_callback(
            '/#[a-fA-F0-9]{6}/',
            function ($matches) {
                $color = $matches[0];
                if ($color[1] == $color[2] && $color[3] == $color[4] && $color[5] == $color[6]) {
                    return '#'.$color[1].$color[3].$color[5];
                } else {
                    return $color;
                }
            },
            $code
        );

        // Разбиваем всё по }, получаем айди/классы + их стили в каждом элементе массива
        $code_array = explode(
            '}',
            $code
        );

        $code_array = array_filter($code_array);    // Убираем пустые строки

        // Удаляем пустые стили
        for ($i = 0; $i < count($code_array); $i++) {
            if ($code_array[$i] && $code_array[$i][-1] == '{') {
                unset($code_array[$i]);
            }
        }

        // Сокращаем padding, margin
        for ($i = 0; $i < count($code_array); $i++) {
            if (str_contains($code_array[$i], 'margin')) {
                $code_array[$i] = $this->compressStyles($code_array[$i], 'margin');
            }
            if (str_contains($code_array[$i], 'padding')) {
                $code_array[$i] = $this->compressStyles($code_array[$i], 'padding');
            }
            $code_array[$i] .= '}';
        }

        $answer = implode($code_array);


        $answer = preg_replace_callback(
            '/margin:\s*(\S+)\s+(\1)\s+(\1)\s+(\1);/',
            function($matches) {
                return "margin:" . $matches[1] . ";";
            },
            $answer
        );


        $answer = preg_replace(
            '/\b0px\b/',
            '0',
            $answer
        );
        
        $answer = str_replace(';}', '}', $answer);

        var_dump($answer);
        return $answer;
    }
}


$solution = new Solution();
$tester = new Tester($solution);

$tester->test(
    tests_dir: $solution->TEST_PATH,
    one_test: 5
);
