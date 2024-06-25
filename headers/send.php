<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

require_once __DIR__ . '/../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

// message
$message = new AMQPMessage('Test Message');
$headers = new AMQPTable([
    'x-match' => 'all', // optional
    'type' => 'report',
    'format' => 'pdf'
]);
$message->set('application_headers', $headers);

// publish
$channel->basic_publish($message,'data.headers');

// ....

$channel->close();
$connection->close();