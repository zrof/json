# Packege SwiftCore Json Manager
The Json Manager class in the SwiftCore framework package is a simple PHP class that provides basic CRUD operations (Create, Read, Update, Delete) on a JSON file. It allows you to easily manipulate JSON data by loading it from a file and then performing operations such as adding, updating, deleting, or retrieving data from the file. It also ensures that any changes made to the data will be saved back to the file when the script completes execution.

```sh
composer require swiftcore/json
```

## Using:

```php
<?php

use SwiftCore\Framework\Json\Json;

$json = new JsonDB('/test.json'); // at the outset slash important

// You can manipulate lots of chains json

$json->create('name', 'Jony'); // creating json {"name":"Jony"}
$json->create('cars.Nissan', 'Sentra'); // creating multidimensional json {"cars":{"Nissan":"Sentra"}}

$json->delete('name'); // deleting json key
$json->delete('cars.Nissan'); // deleting multidimensional json

$json->update('name', 'Leo'); // updating json key
$json->update('cars.Nissan', 'Maxima'); // updating multidimensional json

$json->get('name'); // geting json value
$json->get('cars.Nissan'); // geting multidimensional key for value

$json->all(); // geting all data

```


