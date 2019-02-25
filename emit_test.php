<?php
include 'elephantio.php';
/*
* Version1X arg2 Option : ['context'=>[], 'debug'=>false,'wait'=>100*1000,'timeout'=>ini_get("default_socket_timeout")];
*/

include("elephantio/elephant.io-master/vendor/autoload.php");
echo "체크0";

use ElephantIO\Client, ElephantIO\Engine\SocketIO\Version1X;

$EIO = new Client(new Version1X('http://192.168.122.138:8888', ['timeout' => 1]) );

echo "체크";
if ($EIO->initialize()) {
    echo "성공";
} else {
    echo "실패";
}
echo "체크2";

$EIO->initialize();
$EIO->emit('msgIn', array('data1', 'data2'));
$EIO->close();