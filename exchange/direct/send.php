<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

//$message = new AMQPMessage('Test Message');
$message = new AMQPMessage('Test Message', [
    // message properties
    'content_type' => 'text/plain',
    'content_encoding' => 'gzip',
    'timestamp' => 10000000000,
    'expiration' => (string)time(),
    /**
     * 1 => save on memory and remove while server restart
     * 2 => save on disk (stable)
     */
    'delivery_mode' => 2,
    'app_id' => '11',
    'user_id' => 'admin',
    'type' => 'exchange.queue',
    'headers' => [
        'foo' => 'bar',
        'age' => 12
    ]
]);

$channel->basic_publish($message, 'sendLogDirect', 'log');

// ....

$channel->close();
$connection->close();