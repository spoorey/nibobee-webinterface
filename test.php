<?php
require_once 'vendor/autoload.php';
$dateTime = new DateTime();
echo $dateTime->format('Y-m-d-H-i-') . PHP_EOL;
$seconds = (int) $dateTime->format('s');
$seconds =  $seconds / 10;
echo (int) $seconds;
die();
