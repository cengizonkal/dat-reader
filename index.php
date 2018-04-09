<?php
require_once 'vendor/autoload.php';
$fp = fopen('example.dat', 'r');
$reader = new Conkal\FileReader($fp);
echo "<pre>";
$records = $reader->setFile('example.dat')->setTemplate(['id'=>10])->read(1);
var_dump($records);
$records = $reader->setFile('example.dat')->setTemplate(['id'=>10])->read(2);
$reader->closeFile();

var_dump($records);