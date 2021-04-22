<?php
//входная строка
$in_line = "(n+n)+n#";
//длина входной строки
$str_len = strlen($in_line);
//начальный символ
$stack = "";
//текущее состояние
$cur_state = 0;
//текущий символ
$cur_token = $in_line[0];

//Функция для вывода промежуточных результатов разбора
function output() {
	global $cur_state, $cur_token, $stack, $i, $in_line;
	print_r("i: ");
	print_r($i);
	print_r("<br/>");
	print_r("stack: ");
	print_r($stack);
	print_r("<br/>");
	print_r("cur_state: ");
	print_r($cur_state);
	print_r("<br/>");
	print_r("cur_token: ");
	print_r($cur_token);
	print_r("<br/>");
	print_r("<br/>");
}

//функция для реализации правил грамматики
function rules() {
	global $cur_state, $cur_token, $stack, $i, $in_line;
	switch ($cur_state) {
		case 0:
			switch ($cur_token) {
				case "(":
					$cur_state = 4;
					$stack .= $cur_token;
					$cur_token = $in_line[++$i];
					break;
			}
			break;
		case 1:
			switch ($cur_token) {
				case "+":
					$cur_state = 5;
					$stack .= $cur_token;
					$cur_token = $in_line[++$i];
					break;
				case "#":
					$stack = str_replace("E+T", "E", $stack);
					$cur_state = 1;
					$i++;
					return 1;
					break;
			}
			break;
		case 2:
			switch ($cur_token) {
				case "+":
					$stack = str_replace("T", "E", $stack);
					$cur_state = 6;
					output();
					rules();
					break;
			}
			break;
		case 3:
			switch ($cur_token) {
				case "+":
					$stack = str_replace("n", "T", $stack);
					$cur_state = 2;
					output();
					rules();
					break;
				case ")":
					$stack = str_replace("n", "T", $stack);
					$cur_state = 7;
					output();
					rules();
					break;
				case "#":
					$stack = str_replace("n", "T", $stack);
					$cur_state = 7;
					output();
					rules();
					break;
			}
			break;
		case 4:
			switch ($cur_token) {
				case "+":
					$stack = str_replace("T", "E", $stack);
					$cur_state = 1;
					output();
					rules();
					break;
				case "n":
					$cur_state = 3;
					$stack .= $cur_token;
					$cur_token = $in_line[++$i];
					break;
			}
			break;
		case 5:
			switch ($cur_token) {
				case "n":
					$cur_state = 3;
					$stack .= $cur_token;
					$cur_token = $in_line[++$i];
					break;
			}
			break;
		case 6:
			switch ($cur_token) {
				case "+":
					$stack .= $cur_token;
					$cur_state = 5;
					$cur_token = $in_line[++$i];
					break;
				case ")":
					$stack .= $cur_token;
					$cur_state = 8;
					$cur_token = $in_line[++$i];
					break;
			}
			break;
		case 7:
			switch ($cur_token) {
				case ")":
					$stack = str_replace("E+T", "E", $stack);
					$cur_state = 6;
					output();
					rules();
					break;
				case "#":
					$stack = str_replace("E+T", "E", $stack);
					$cur_state = 1;
					output();
					rules();
					break;
			}
			break;
		case 8:
			switch ($cur_token) {
				case "+":
					$stack = str_replace("(E)", "T", $stack);
					$cur_state = 4;
					output();
					rules();
					break;
			}
			break;
	}
}

$i = 0;
output();

//цикл по входному слову
while ($i <= $str_len) {
	$result = rules();
	output();
}

if ($result === 1) {
	echo "допуск. Cвертка по нулевому правилу";
}