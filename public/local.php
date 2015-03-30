<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/2/7
 * Time: 上午1:57
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

$loader = include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../app/Application.php';

$app = new Application('local');

$app->bootstrap();

$response = $app->handleHttpRequest();

$response->send();

$app->terminate($response);

