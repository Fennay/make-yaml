<?php
/**
 * Created by PhpStorm.
 * User: Mikey
 * Date: 2017/11/8
 * Time: 22:03
 */


$redis = new Redis();
$redis->connect('192.168.1.105',6379);
$redis->auth('123456');
$redisName = 'miaosha';

$num = 10;
// 1,判断是否达到数量
// 2，推入队列
for ($i=1;$i<100;$i++){
    if($redis->lLen($redisName) < 10){
        $redis->lPush($redisName,$i.'%'.microtime());
        echo $i.'秒杀成功';
    }else{
        echo '秒杀失败';
    }
}
