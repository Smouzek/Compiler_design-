<?php
//входная строка
$in_line = "(a+a)*a";
//длина входной строки
$str_len = strlen($in_line);
//начальный символ
$stack = "S";
print_r("Входная строка: ");
print_r($in_line);
print_r("<br/>");
print_r("<br/>");

//правила грамматики
function rules ($str, $mode, $follow) {
	global $math;
	//return $math;
	switch ($mode) {
		case 1: 
			$str = str_replace('S', 'AS', $str);
			break;
		case 2: 
			$str = str_replace('A', $follow, $str);
			break;
		case 3: 
			$str = str_replace('S', 'FS', $str);
			break;
		case 4: 
			$str = str_replace('F', 'a', $str);
			break;
	}
	return $str;
}

//цикл перебора символов входной строки
for ($i = 0; $i < $str_len; $i++) {
	$j = true;
	//очердной символ строки
	$follow = $in_line[$i];
	//применение правил управляющей таблицы
	while ($j) {
		//верхушка стека
		$first = $stack[0];
		//вывод значений на каждой итерации цикла
		print_r("i: ");
		print_r($i);
		print_r("<br/>");
		print_r("stack: ");
		print_r($stack);
		print_r("<br/>");
		print_r("first: ");
		print_r($first);
		print_r("<br/>");
		print_r("follow: ");
		print_r($follow);
		print_r("<br/>");
		print_r("<br/>");
		//если символ верхушки стека совпадает с очередным символом входной строки
		if ($first == $follow) {
			//удаляем верхний элемент из стека
			$stack = substr($stack, 1);
			//заканчиваем обработку в цикле while, переходим к i++
			$j = false;
		} else {
			//условия для применений правил из управляющей таблицы
			switch ($first) {
				case "S":
					switch ($follow) {
						case "(":
						case ")":
						case "+":
						case "-":
						case "*":
						case "/":
							$stack = rules($stack, 1, "");
							break;
						case "a":
							$stack = rules($stack, 3, "");
							break;
						default:
							exit("Слово не принадлежит грамматике");
					}
					break;
				case "A":
					switch ($follow) {
						case "(":
						case ")":
						case "+":
						case "-":
						case "*":
						case "/":
							$stack = rules($stack, 2, $follow);
							break;
						default:
							exit("Слово не принадлежит грамматике");
					}
					break;
				case "F":
					switch ($follow) {
						case "a":
							$stack = rules($stack, 4, "");
							break;
						default:
							exit("Слово не принадлежит грамматике");
					}
					break;	
			}
		}
	}
}
if ($i == $str_len) {
	echo "Входная строка является арифметическим выражением";
}
