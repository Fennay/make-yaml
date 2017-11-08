<?php

namespace MakeYaml;

require_once __DIR__ . '/vendor/autoload.php';

use Spyc;

class MakeYaml
{
    public function run($data,$name)
    {
        // 如果没有版本，自动加上swagger2
        if(empty($data['swagger'])){
            $data['swagger'] = 2;
        }
        try {
            $value = Spyc::YAMLDump($data,1,60,true);
        } catch (Exception $exe) {
            var_dump($exe->getMessage());
        }

        // 写入文件
        file_put_contents('./yaml/'.$name,$value);
    }
}

$get = $_GET;
echo '<pre>';
unset($get['s']);
$yaml = handle($get);
$name = 'test2433.yaml';
$makeYaml = new MakeYaml();
$makeYaml->run($yaml,$name);
