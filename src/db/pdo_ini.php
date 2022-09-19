<?php
/** @var PDO $pdo */
require_once './pdo_ini.php';
$config = require_once './config.php';

$pdo = new PDO(
    sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']),
    $config['user'],
    $config['pass'],
);