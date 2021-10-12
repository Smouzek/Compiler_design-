<?php

//php 1.php mode=1 name1=ivanov name2=ivan name3=ivanovich
//php 1.php mode=2 patient_id=1
//php 1.php mode=3 name1=ivanov name2=ivan name3=ivanovich oms=3029539554903272

header('Content-Type: text/html; charset=CP1251');

parse_str(implode('&', array_slice($argv, 1)), $_GET);

print_r($_GET);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "root", "kis");
$mysqli->query("SET NAMES 'utf8';");

$mode = $_GET['mode'];
$name1 = $_GET['name1'];
$name2 = $_GET['name2'];
$name3 = $_GET['name3'];
$oms = $_GET['oms'];
$patient_id = $_GET['patient_id'];

switch ($mode) {
    case 1:
        new_patient($name1, $name2, $name3);
        break;
    case 2:
        add_test($patient_id);
        break;
    case 3:
        get_record($name1, $name2, $name3, $oms);
        break;
}

function new_patient($name1, $name2, $name3) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO patient(name1, name2, name3, OMS) VALUES (?, ?, ?, ?)");

    // for ($i = 0; $i < 9; $i++) {
        generator($stmt, $name1, $name2, $name3);
        generator($stmt, $name1, $name3, $name2);
        generator($stmt, $name2, $name1, $name3);
        generator($stmt, $name2, $name3, $name1);
        generator($stmt, $name3, $name2, $name1);
        generator($stmt, $name3, $name1, $name2);

    //     $stmt->bind_param("ssss", $name1, $name2, $name3, $oms);
    //     if ($stmt->execute() === true) {
    //         echo "Запись добавлена";
    //     } else {
    //         echo "Возникла ошибка при добавлении записи";
    //     }
    // }
}

function generator($stmt, $name1, $name2, $name3) {
    $oms = "";
    for ($i = 0; $i < 16; $i++) {
        $oms .= rand(0, 9);
    }
    $stmt->bind_param("ssss", $name1, $name2, $name3, $oms);
    if ($stmt->execute() === true) {
        echo "Запись добавлена";
    } else {
        echo "Возникла ошибка при добавлении записи";
    }
}

//создание теста для пациента
function add_test($patient_id) {
    global $mysqli;
    //создание записи типа теста
    $persents_arr = array("93", "94", "96", "97");
    $persent = rand(0, 3);
    $mysqli->query("
        INSERT INTO test_type(name, accuracy_quality)
        VALUES('Lg(m)', '{$persents_arr[$persent]}')
    ");
    $type_id = $mysqli->insert_id;
    //создание записи лаборатории
    $labs_arr = array("ANIVAc", "UniLab", "MMIc");
    $lab_index = rand(0, 2);
    $mysqli->query("
        INSERT INTO labs(name)
        VALUES('{$labs_arr[$lab_index]}')
    ");
    $lab_id = $mysqli->insert_id;
    //создание записи результата
    $res_arr = array("plus", "minus");
    $res_index = rand(0, 1);
    $mysqli->query("
        INSERT INTO results(value)
        VALUES('{$res_arr[$res_index]}')
    ");
    $res_id = $mysqli->insert_id;
    //создание записи теста
    $mysqli->query("
        INSERT INTO tests(patient_id, date, test_type_id, lab_id, result_id)
        VALUES('{$patient_id}', NOW(), '{$type_id}', '{$lab_id}', '{$res_id}')
    ");
    $test_id = $mysqli->insert_id;
    return $test_id;
}

function get_record($name1, $name2, $name3, $oms) {
    global $mysqli;
    $stmt = $mysqli->prepare("
        SELECT *
        FROM patient p
        LEFT JOIN tests t ON p.id = t.patient_id
        LEFT JOIN test_type tt ON tt.id = t.test_type_id
        LEFT JOIN labs l ON l.id = t.lab_id
        LEFT JOIN results r ON r.id = t.result_id
        WHERE p.name1 = ? AND p.name2 = ? AND p.name3 = ?
        AND p.OMS = ?
    ");
    $stmt->bind_param("ssss", $name1, $name2, $name3, $oms);
    $red = array();
    if ($stmt->execute() === true) {
        $red = $stmt->get_result();
        $row = array();
        $res_array = array();
        $i = 0;
        while ($row = $red->fetch_array(MYSQLI_NUM)) {
            $res_array[$i] = $row;
            $i++;
        }
        print_r($res_array);
    } else {
        echo "Возникла ошибка при выполнения запроса";
    }
    return $res_array;
}
