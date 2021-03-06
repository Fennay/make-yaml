<?php

namespace MakeYaml;

require_once __DIR__ . '/vendor/autoload.php';

use Spyc;

class MakeYaml
{

    protected $data;
    protected $fileName;
    protected $getData;

    public function __construct($getData, $fileName = 'test.yaml')
    {
        $this->getData = $getData;
        $data = [];
        $data['swagger'] = '2.0';
        $data['info'] = $this->info();
        $data['host'] = $this->host();
        $data['host'] = $this->get('basePath');
        $data['host'] = $this->get('schemes');
        $data['paths'] = $this->handlePath($getData['path']);
        $this->data = $data;
        $this->fileName = $fileName;

    }

    protected function info()
    {
        $license = [
            'MIT'       => 'https://opensource.org/licenses/MIT',
            'Apache2.0' => 'https://opensource.org/licenses/Apache-2.0',
            'BSD3'      => 'https://opensource.org/licenses/BSD-3-Clause',
            'BSD2'      => 'https://opensource.org/licenses/BSD-2-Clause',
            'GPL'       => 'https://opensource.org/licenses/gpl-license',
            'Mozilla'   => 'https://opensource.org/licenses/MPL-2.0',
            'LGPL'      => 'https://opensource.org/licenses/lgpl-license',
        ];
        $info = $this->getData['info'];
        $info['license']['url'] = $license[$info['license']['name']];

        return $info;
    }

    protected function host()
    {
        $host = $this->getData['host'];
        $prefix = 'http://';
        $return = !empty($host) && (false === stripos($host, $prefix))
            ?
            $return = $prefix . $host
            :
            '';

        return $return;
    }

    protected function get($key)
    {
        return $this->getData[$key];
    }

    public function run()
    {
        // 如果没有版本，自动加上swagger2
        if (empty($this->data['swagger'])) {
            $this->data['swagger'] = 2;
        }
        try {
            // 移除所有空元素
            $this->data = removeEmpty($this->data);
            $value = Spyc::YAMLDump($this->data, 1, 60, true);
        } catch (Exception $exe) {
            var_dump($exe->getMessage());
        }

        $returnData = [
            'status' => 'success',
            'info'   => '转换成功',
            'data'   => $value
        ];
        echo json_encode($returnData);
    }

    /**
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

    protected function licenses()
    {

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

