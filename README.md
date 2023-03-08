# JsonDB
The JsonDB class is a simple PHP class that provides basic CRUD (create, read, update, delete) operations on a JSON file. It allows you to easily manipulate JSON data by loading it from a file, and then perform operations such as adding, updating, deleting, or retrieving data from the file. It also ensures that any changes made to the data are saved back to the file when the script finishes executing.

```sh
composer require swiftcore/json
```

# Documentation

## Constructor:

`__construct(string $filename)`: Constructs the JsonDB object and loads the JSON data from the specified file. If the file doesn't exist, it creates an empty one.

## Methods:

`create(string $key, string|array $value): void` Adds a new key-value pair to the database.

`delete(string $key): void` Removes a key-value pair from the database.

`update(string $key, string|array $value): void` Updates the value of an existing key in the database.

`get(string $key): string|array` Retrieves the value associated with the given key in the database. The key can be a dot-separated string to access nested values.

`all(): array` Returns all data stored in the database.

## Destructor:

`__destruct()` Writes the current data in the JsonDB object to the JSON file when the object is destroyed.

## Exceptions:

`Exception("Failed to parse JSON data from file: {$this->filename}")` Thrown if the JSON data cannot be parsed from the file.

`Exception("Failed to write JSON data to file: {$this->filename}")` Thrown if the JSON data cannot be written to the file.

`Exception("Key must be a string, " . gettype($key) . " given")` Thrown if the key parameter passed to set(), delete(), or update() is not a string.

`Exception("Value must be a string or an array, " . gettype($value) . " given")` Thrown if the value parameter passed to set() or update() is not a string or an array.

`Exception("Key does not exist: {$key}")` Thrown if the specified key is not found in the database.

## Using:

```php
<?php

use Zrof\Json\JsonDB;

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


