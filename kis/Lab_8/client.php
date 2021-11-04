<?php

$address = "127.0.0.1"; // Записываем в переменную имя хоста
$port = 4545;
$socketObject = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Создаем объект сокета и добавляем в него нужные параметры, состоящие из предопределенных констант

$file_content = file_get_contents('test.json');
socket_connect($socketObject, $address, $port); // Присоединяемся к клиенту в случае отправки запроса с его стороны
socket_write($socketObject, $file_content); //Делаем начальную запись в сокет

$result = ""; // Переменная для хранения данных, передаваемых по сети

socket_close($socketObject); //Закрываем соединение