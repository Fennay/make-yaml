<?php
namespace MakeYaml;

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$yaml = file_get_contents('./yaml/test.yaml');
try {
    $value = Yaml::parse($yaml);
} catch (Exception $exe) {
    echo '报错：';
    var_dump($exe->getMessage());
}

echo '<pre>';
var_dump($value);