<?php

/**
 * Class DefineState
 */
Class DefineState
{
    /**
     * Функция для определения очередного состояния
     * @param $state - текущее состояние
     * @param $literal - текущий символ слова
     * @return int - новое состояние
     */
    public function newState($state, $literal)
    {
        switch($state) {
            case 0:
                switch($literal) {
                    case "A":
                        $result = 1;
                        break;
                    case "B":
                    case "C":
                        $result = 0;
                        break;
                }
                break;
            case 1:
                switch($literal) {
                    case "A":
                        $result = 1;
                        break;
                    case "B":
                        $result = 2;
                        break;
                    case "C":
                        $result = 0;
                        break;
                }
                break;
            case 2:
                switch($literal) {
                    case "A":
                        $result = 3;
                        break;
                    case "B":
                    case "C":
                        $result = 0;
                        break;
                }
                break;
            case 3:
                switch($literal) {
                    case "A":
                        $result = 1;
                        break;
                    case "B":
                        $result = 4;
                        break;
                    case "C":
                        $result = 0;
                        break;
                }
                break;
            case 4:
                switch($literal) {
                    case "A":
                        $result = 5;
                        break;
                    case "B":
                    case "C":
                        $result = 0;
                        break;
                }
                break;
            case 5:
                switch($literal) {
                    case "A":
                        $result = 1;
                        break;
                    case "B":
                        $result = 4;
                        break;
                    case "C":
                        $result = 6;
                        break;
                }
                break;
            // case 6:
            // 	break;
        }
        return $result;
    }
}
//входное слово
$in_string = "ABABAC";
//начальное состояние
$current_state = 0;
$defineState = new DefineState();
for ($i = 0; $i < strlen($in_string); $i++) {
    $current_state = $defineState->newState($current_state, $in_string[$i]);
}
//вывод результата
print_r("Входная строка: ");
print_r($in_string);
print_r("<br/>");
print_r("Конечное состояние: ");
print_r($current_state);