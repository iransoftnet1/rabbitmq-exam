<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

$callback = function (AMQPMessage $message){
    echo $message->body . PHP_EOL;
};

$channel->basic_consume('headers_queue','', false, true, false, false, $callback);

while ($channel->getConnection()->isConnected()) {
    $channel->wait();
}