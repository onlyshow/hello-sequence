<?php

require __DIR__ . '/vendor/autoload.php';

$server = new SequenceRedisServer();
$server->start();
