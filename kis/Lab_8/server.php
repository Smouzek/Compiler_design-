<?php

$address = "127.0.0.1";
$port = 4545;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if( !$socket ) exit( socket_strerror( socket_last_error() ) );
else echo 'Socket_created!'."\r\n";

if( !socket_bind($socket, $address, $port) ) exit( socket_strerror( socket_last_error() ) );
else echo 'Socket_binded!'."\r\n";

if( !socket_listen($socket, 10) ) exit( socket_strerror( socket_last_error() ) );
else echo 'Socket_listen!'."\r\n";
$count_connect = 0;
while (true) {
    $connect = socket_accept($socket);
    if ($connect !== false) {
        $result = socket_read($connect,1024);
        $upload_file = $result;
        $count_connect++;
        if ($count_connect == 1) {
            echo 'Uploaded data: '.$result."\r\n";
        } elseif ($count_connect == 2) {
            if ($upload_file) {
                $json = json_decode($upload_file, true);
                print_r($json[rand(1, count($json))]);
            }
        } else {
            echo "error";
        }
        socket_write($connect,'You sending me: '.$result."\r\n");
    }
}
socket_shutdown($connect);
socket_close($socket);
