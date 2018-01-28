#!/usr/bin/env php
<?php
$startTime = microtime(true);

require_once __DIR__.'/vendor/autoload.php';

const BASE_DIR = __DIR__;

$app = new \Cilex\Application('crawler', '0.1', array('console.class' => 'Crawler\Application', 'skylab.starttime' => $startTime, 'php_version' => PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION));

$app->command(new \Crawler\Command\CrawlCommand());

$app->run();
