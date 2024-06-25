<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

$message = $argv[1]; // 'test message'
$routeKey = $argv[2]; // 'name.user.update.1'

$data = new AMQPMessage($message);
$channel->basic_publish($data, 'updateSystemTopic', $routeKey);

// ....

$channel->close();
$connection->close();