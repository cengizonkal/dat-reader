<?php
require_once 'vendor/autoload.php';

$reader = new DatReader\Reader('example.dat');
echo "<pre>";
$template = ['id' => 10, 'name' => 13];


$reader->setTemplate($template)->each(
    function ($records) {
        var_dump($records);
    }, 1);


$reader->closeFile();

