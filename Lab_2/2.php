<?php
//входной текст
$in_text = "<br/>Integer proverka;<br/>
Integer a = 2, b = 3, c = 4;
proverka = a + b * c;<br/>
if (proverka > 0) {;<br/>
echo proverka;<br/>
}";
print_r("Входной текст: ");
print_r($in_text);
print_r("<br/>");
print_r("<br/>");
//массив ключевых слов
$key_words = array("if", "else", "array", "explode", "for", "foreach", "print_r", "echo", "Integer");
$chr = array(' ', '=', ')', '(', '.', '*', '+', '-', '/', '%', ';');
$array = array();


//разбиваем строку по символу конца строки
$string = explode(PHP_EOL, $in_text);
print_r("Массив строк: ");
print_r($string);
print_r("<br/>");
print_r("<br/>");

foreach ($string as $value) {
	$array_pos = array();
	array_push($array_pos, -1);
	//Прогоняем строку посимвольно - ищем позиции разделителей
	for ($i = 0; $i < strlen($value); $i++) {
		if (array_search($value[$i], $chr) !== false) {
			array_push($array_pos, $i);
		}
	}
	//Определяем по регулярному выражение, является ли фрагмент строки идентификатором
	for ($i = 0; $i < count($array_pos) - 1; $i++) {
		$start_pos = $array_pos[$i] + 1;
		$end_pos = $array_pos[$i + 1];
		$length = $end_pos - $start_pos;
		$interval = substr($value, $start_pos, $length);
		//проверяем на совпадение с ключевыми словами
		if (array_search($interval, $key_words) === false) {
			if (preg_match('/(^[a-zA-Z]{1}\w*$)/', $interval) !== 0) {
				array_push($array, $interval);
			}
		}
	}
}
print_r("Массив идентификаторов: ");
print_r($array);
