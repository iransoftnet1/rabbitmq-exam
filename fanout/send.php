<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

$data = new AMQPMessage(json_encode(['key' => 'number#1']));

$channel->basic_publish($data, 'purgeDataFanout');

// ....

$channel->close();
$connection->close();