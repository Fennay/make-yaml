<?php
/**
 * Created by PhpStorm.
 * User: Mikey
 * Date: 2017/11/8
 * Time: 22:08
 */

$redis = new Redis();
$redis->connect('192.168.1.105',6379);
$redis->auth('123456');

$redisName = 'miaosha';

$user = $redis->lPop($redisName);
echo '<pre>';
var_dump($user);