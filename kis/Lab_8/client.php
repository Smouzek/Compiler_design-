<?php

$address = "127.0.0.1"; // ���������� � ���������� ��� �����
$port = 4545;
$socketObject = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // ������� ������ ������ � ��������� � ���� ������ ���������, ��������� �� ���������������� ��������

$file_content = file_get_contents('test.json');
socket_connect($socketObject, $address, $port); // �������������� � ������� � ������ �������� ������� � ��� �������
socket_write($socketObject, $file_content); //������ ��������� ������ � �����

$result = ""; // ���������� ��� �������� ������, ������������ �� ����

socket_close($socketObject); //��������� ����������