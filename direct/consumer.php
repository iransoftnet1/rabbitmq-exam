<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../vendor/autoload.php';
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456');
$channel = $connection->channel();

$callback = function (AMQPMessage $message)use ($channel) {
    echo $message->body . PHP_EOL;
    //sleep(3);
    $channel->basic_ack($message->delivery_info['delivery_tag']);
    // $channel->basic_nack($message->delivery_info['delivery_tag']);
};

$channel->basic_consume('log_queue','', false, false, false, false, $callback);
/**
 * queue: نام queue
 * exclusive: می گه فقط یک کانسیومر بتنه به این صف وصل بشه
 * no_ack: به صورت خودکار بعد از callback میاد ack رو صدا میزنه، اگه false کنید باید در داخل callback ack را صدا بزنید.
 */
// ....

while ($channel->getConnection()->isConnected()) {
    $channel->wait();
}