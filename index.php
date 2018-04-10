<?php
require_once 'vendor/autoload.php';
$fp = fopen('example.dat', 'r');
$reader = new Conkal\FileReader($fp);
echo "<pre>";


$template = ['id' => 10, 'name' => 13];
$records = $reader->setFilename('example.dat')
    ->setTemplate($template)
    ->read(1);
var_dump($records);
$reader->each(10, function ($records) {
    var_dump($records);
});
$reader->closeFile();

