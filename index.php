<?php
require_once 'vendor/autoload.php';

$reader = new DatReader\Reader('example.dat', ['id' => 10, 'name' => 13]);

$reader->each(
    function ($records) {
        var_dump($records);
    });


$reader->closeFile();

