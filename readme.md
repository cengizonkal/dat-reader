```php
<?php
require_once 'vendor/autoload.php';

/**
 * A large text file
 */
$fileName = 'example.dat';

/**
 * How fixed columns arranged
 * example: 10 characters for id, 13 characters for name
 */
$template = ['id' => 10, 'name' => 13];

/**
 * Create Reader
 */
$reader = new Conkal\DatReader\Reader($fileName, $template);

/**
 * Read each line as fixed column records
 */
$reader->open();
while ($record = $reader->read()) {
    var_dump($record);
}
$reader->close();

```