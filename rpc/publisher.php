<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// connection
require_once __DIR__ . '/../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();


// create answer queue
$channel->queue_declare('answer-queue');

// create job message
$channel->queue_declare('request-queue');
$cor_id = uniqid(); # unique id message

// create message
$message = new AMQPMessage('Test Message',
    [
        # properties
        'reply_to' => 'answer-queue',
        'correlation_id' => $cor_id,
    ]
);

// publish
$channel->basic_publish($message, '', 'request-queue');

// ....
$channel->close();
$connection->close();