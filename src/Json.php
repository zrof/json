<?php

/*
 * This file is part of zrof/jsondb.
 *
 * (c) Mister Zrof <zrof@mulgate.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.

 */

namespace SwiftCore\Framework\Json;

use SwiftCore\Framework\Json\Exception\JsonException;

class Json
{

    protected array $data;
    protected string $delimiter;
    private string $filename;

    /**
     * Constructor - makes and downloads a json file
     * @param string $filename
     * @param string $delimiter (optional) delimiter to split the key into multiple levels (default '.')
     */

    public function __construct($filename, $delimiter = '.')
    {
        $this->filename = __DIR__ . $filename;

        if(!file_exists($this->filename) && !filesize(__DIR__.$this->filename)) {
            $fp = fopen($this->filename, 'w');
              fwrite($fp, '{}');
              fclose($fp);
          }

        $this->data = json_decode(file_get_contents($this->filename), true);
        $this->delimiter = $delimiter;

        if ($this->data === null) {
            throw new JsonException("Failed to parse JSON data from file: {$this->filename}");
        }

    }

    /**
    * Destructor - writes an elements in the file
    */

    public function __destruct()
    {
        $result = file_put_contents($this->filename, json_encode($this->data));

        if ($result === false) {
            throw new JsonException("Failed to write JSON data to file: {$this->filename}");
        }
    }


    /**
     * Retuns all json data
     * @return array
     */

     public function all()
     {
         return $this->data;
     }


     /**
      * Adds a new element to the array
      * @param string $key
      * @param string|array $value
      * @throws JsonException if key is not a string or value is not a string or an array
      * @return void
      */

     public function create($key, $value)
     {
         if (!is_string($key)) {
             throw new JsonException("Key must be a string, " . gettype($key) . " given");
         }

         if (!is_string($value) && !is_array($value)) {
             throw new JsonException("Value must be a string or an array, " . gettype($value) . " given");
         }

         $keys = explode($this->delimiter, $key);
         $array = &$this->data;

         foreach ($keys as $i => $key) {
             if (!isset($array[$key])) {
                 if ($i === count($keys) - 1) {
                     $array[$key] = $value;
                 } else {
                     $array[$key] = [];
                 }
             }

             $array = &$array[$key];

         }
     }


    /**
     * Deletes an element in the database by a dot-separated chain of keys.
     * @param string $key A dot-separated chain of keys.
     * @throws JsonException If the key chain is invalid or the key does not exist.
     * @return void
     */

    public function delete($key)
    {
        if ($key === '') {
            throw new JsonException('Invalid empty key chain');
        }

        $keys = explode($this->delimiter, $key);
        $array = &$this->data;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                throw new JsonException("Key '{$key}' does not exist in the database");
            }

            $array = &$array[$key];
        }

        unset($array);
    }


    /**
     * Updates an element in the database by a dot-separated chain of keys.
     *
     * @param string $key A dot-separated chain of keys.
     * @param string|array $value The new value to set for the key.
     * @throws Exception If the key chain is invalid or the value is not a string or an array.
     * @return void
     */

    public function update($key, $value)
    {
        if ($key === '') {
            throw new Exception('Invalid empty key chain');
        }

        $keys = explode($this->delimiter, $key);
        $array = &$this->data;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                throw new Exception("Key '{$key}' does not exist in the database");
            }

            $array = &$array[$key];
        }

        if (!is_string($value) && !is_array($value)) {
            throw new Exception("Value must be a string or an array, " . gettype($value) . " given");
        }

        $array = $value;
    }



    /**
     * Retrieves an element from the database by a dot-separated chain of keys.
     *
     * @param string $key A dot-separated chain of keys.
     * @return mixed The value associated with the key chain, or null if the key is not found.
     * @throws Exception If the key chain is invalid or the key is not found.
     */

    public function get($key)
    {
        if ($key === '') {
            throw new Exception("Invalid empty key chain");
        }

        $keys = explode($this->delimiter, $key);
        $array = &$this->data;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                throw new Exception("Key '{$key}' does not exist in the database");
            }

            $array = &$array[$key];
        }

        return $array;
    }

}
