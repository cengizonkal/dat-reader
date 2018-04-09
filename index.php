<?php
require_once 'vendor/autoload.php';
$fp = fopen('example.dat', 'r');
$reader = new Conkal\FileReader($fp);

$records = $reader->setFile('example.dat')->setTemplate(['id'=>10])->read();

var_dump($records);