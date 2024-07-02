<?php

/**
 * Считывание всех переменных из секретного .env файла, таких как
 * пароль от бд, юзер, пароли от почты
 */
function get_dotenv_vars(string $dotenv_path) : void
{
    if (file_exists($dotenv_path)) {
        $lines = file($dotenv_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            list($key, $value) = explode('=', $line);
            $key = trim($key);
            $value = trim($value);
            $_ENV[$key] = $value;
        }
    }
}