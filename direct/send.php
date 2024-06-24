<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

$message = new AMQPMessage('Test Message');

$channel->basic_publish($message, 'sendLogDirect', 'log');

// ....

$channel->close();
$connection->close();