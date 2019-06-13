<?php
require_once 'vendor/autoload.php';

/**
 * A large text file
 */
$reader = new DatReader\Reader('example.dat', ['id' => 10, 'name' => 13]);

/**
 * Read each line as fixed column records
 */
$reader->open();
while ($record = $reader->read()) {
    var_dump($record);
}
$reader->close();

