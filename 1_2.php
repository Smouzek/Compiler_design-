<?php
//создние массива, который будет использоваться в качестве стека
$stack = array();
//состояние автомата
$state = 0;
/**
 * Функция реализации работы МП-автомата для очередного символа слова
 * @param $literal - очередная буква слова
 */
function getNewState($literal)
{
    global $stack;
    global $state;
    switch ($state) {
        case 0:
            if ($literal == 0) {
                $state = 1;
                if (empty($stack)) {
                    array_push($stack, 0);
                }
            } elseif ($literal == "" && empty($stack)) {
                $state = 3;
            }
            break;
        case 1:
            if ($literal == 0) {
                if ($stack[(count($stack) - 1)] == 0) {
                    array_push($stack, 0);
                }
            } elseif ($literal == 1) {
                if ($stack[(count($stack) - 1)] == 0) {
                    $state = 2;
                    array_pop($stack);
                }
            }
            break;
        case 2:
            if ($literal == 1) {
                if ($stack[(count($stack) - 1)] == 0) {
                    array_pop($stack);
                }
            } elseif ($literal == "" && empty($stack)) {
                $state = 3;
            }
            break;
    }
}

$in_string = array();
//Количество нулей и единиц во входном слове
$n = 10;
//Формирование входного слова
for ($i = 0; $i < $n; $i++) {
    array_push($in_string, 0);
}
for ($i = 0; $i < $n; $i++) {
    array_push($in_string, 1);
}

for ($i = 0; $i <= 2 * $n; $i++) {
    getNewState($in_string[$i]);
}
//вывод результата
print_r("Входное слово: ");
foreach ($in_string as $value) {
    echo $value;
}
print_r("<br/>");
print_r("Состояние: " . $state);
print_r("<br/>");
print_r("Стэк: ");
print_r($stack);