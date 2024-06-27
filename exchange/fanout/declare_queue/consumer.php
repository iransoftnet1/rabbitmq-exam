<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../../../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

// create dynamic queue
list($queueName, ,) = $channel->queue_declare('', false, false, false, false);
$channel->queue_bind($queueName,'purgeDataFanout');

// --

$callback = function (AMQPMessage $message) use ($channel) {
    echo $message->body . PHP_EOL;
    echo $message->delivery_info['routing_key'];
};

$channel->basic_consume($queueName, '', false, true, false, false, $callback);

while ($channel->getConnection()->isConnected()) {
    $channel->wait();
}

$channel->close();
$connection->close();