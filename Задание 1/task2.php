<?php

/*
В БД хранятся новости, содержащие ссылки на внешнюю систему такого вида:
http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=<номер законопроекта>&<целое число>
Например: https://pastebin.com/sNk6ntM4, https://pastebin.com/VmtfjiMb
Система переехала на новую платформу и ссылки стали иметь формат 
http://sozd.parlament.gov.ru/bill/<номер законопроекта>
Подготовить скрипт, который с помощью регулярного выражения заменит в БД ссылки старого формата на новые.
Номер законопроекта может содержать цифры и дефис.
*/

function reformatLink(string $link) : string
{
    $pattern = '/http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=([0-9-]+)&[0-9]+/';
    $newFormat = 'http://sozd.parlament.gov.ru/bill/$1';
    return preg_replace($pattern, $newFormat, $link);
}


$oldLink = "http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=123-456&789";
$newLink = reformatLink($oldLink);

echo $newLink;