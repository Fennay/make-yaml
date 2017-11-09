<?php
/**
 * Created by PhpStorm.
 * User: Mikey
 * Date: 2017/11/4
 * Time: 15:56
 */

/**
 * 处理多维数组，删除空元素
 * @param $data
 * @return mixed
 */
function removeEmpty($data)
{
    foreach ($data as $k => $v) {
        if(is_array($v)) {
            $data[$k] = removeEmpty($v);
        }
        // 删除空元素
        if(empty($v) || ( 0 == count($data[$k]))) {
            unset($data[$k]);
        }
    }

    return $data;
}