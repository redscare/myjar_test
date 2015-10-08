<?php

require_once __DIR__ . '/vendor/autoload.php';

$service = new AMPQConnector();
$service->host = 'impact.ccat.eu';
$service->port = '5672';
$service->user = 'myjar';
$service->pass = 'myjar';
$service->inQueueName = 'interest-queue';
$service->outQueueName = 'solved-interest-queue';
$service->token = 'vp';
$service->connect();
$service->runService();
$service->shutdown();