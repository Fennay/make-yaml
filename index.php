<?php

namespace MakeYaml;

require_once __DIR__ . '/vendor/autoload.php';

use Spyc;

class MakeYaml
{

    protected $data;
    protected $fileName;

    public function __construct($getData,$fileName='')
    {
        $data = [];
        $data['swagger'] = '2.0';
        $data['info'] = $getData['info'];
        $data['paths'] = $this->handlePath($getData['path']);
        $fileName = '12312313.yaml';
        $this->data = $data;
        $this->fileName = $fileName;
        echo '<pre>';
        print_r($this->data);
    }

    public function run()
    {
        // 如果没有版本，自动加上swagger2
        if(empty($this->data['swagger'])) {
            $this->data['swagger'] = 2;
        }
        try {
            // 移除所有空元素
            $this->data = removeEmpty($this->data);
            $value = Spyc::YAMLDump($this->data, 1, 60, true);
            print_r($value);
            // 写入文件
            // file_put_contents('./yaml/' . $this->fileName, $value);
        } catch (Exception $exe) {
            var_dump($exe->getMessage());
        }

        // echo '执行成功';
    }

    /**
     *
     * @param $path
     * @return array
     */
    protected function handlePath($path)
    {
        $newPath = [];
        foreach ($path as $k => $v) {
            $key = $v['path'] . $v['type'];
            $newPath[$key]['tags'] = $v['tags'];
            $newPath[$key]['description'] = $v['description'];
            $newPath[$key]['parameters'] = $v['parameters'];
            $newPath[$key]['consumes'] = $v['consumes'];

        }

        return $newPath;
    }
}

// $get = $_GET;
// echo '<pre>';
// unset($get['s']);
//
// $path = $get['path'];
// print_r($get);
// die;
// $yaml = removeEmpty($get);
$name = 'test2433.yaml';
$makeYaml = new MakeYaml($_GET, $name);
$makeYaml->run();
