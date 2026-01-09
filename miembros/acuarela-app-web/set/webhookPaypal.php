<?php

$logFile = 'webhooks_paypal.log';
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
$logEntry = date('Y-m-d H:i:s') . " - " . print_r($data, true) . PHP_EOL;
file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);