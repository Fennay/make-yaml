<?php

namespace MakeYaml;

require_once __DIR__ . '/vendor/autoload.php';

use Spyc;

class MakeYaml
{

    protected $data;
    protected $fileName;

    public function __construct($getData,$fileName='test.yaml')
    {
        $data = [];
        $data['swagger'] = '2.0';
        $data['info'] = $getData['info'];
        $data['paths'] = $this->handlePath($getData['path']);
        $this->data = $data;
        $this->fileName = $fileName;
        echo '<pre>';
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
            $key = $v['path'];
            $newPath[$key][$v['type']]['tags'][0] = $v['tags'];
            $newPath[$key][$v['type']]['description'] = $v['description'];
            $newPath[$key][$v['type']]['parameters'] = $v['parameters'];
            $newPath[$key][$v['type']]['consumes'] = $v['consumes'];

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
$name = 'test.yaml';
$makeYaml = new MakeYaml($_GET, $name);
$makeYaml->run();
