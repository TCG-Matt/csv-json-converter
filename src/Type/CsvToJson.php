<?php

namespace Pearl\CsvJsonConverter\Type;

use Pearl\CsvJsonConverter\ConverterAbstract;

class CsvToJson extends ConverterAbstract
{
    /**
     * Constructor.
     *
     * @param  string  $data
     * @param  array  $options
    */

    public function __construct($data = null, array $options = [])
    {
        parent::__construct($data, $options);
        $this->conversion = [
            'extension' => 'json', 
            'type' => 'application/json',
            'delimiter' => ',', 
            'enclosure' => '"', 
            'escape' => '\\'
        ];
    }

    /**
     * Convert the csv to array.
     *
     * @param  string  $data
     * @return void
    */

    protected function setData($data)
    {
        $this->data = array_filter(explode(PHP_EOL, $data));
    }

    /**
     * Convert the csv to json.
     *
     * @return  string|\Exception
    */

    public function convert()
    {
        if (empty($this->data) === false && is_array($this->data)) {
            $bitmask = empty($this->options['bitmask']) === false ? $this->options['bitmask'] : 0;
            $keys = str_getcsv(array_shift($this->data), $this->conversion['delimiter'], $this->conversion['enclosure'], $this->conversion['escape']);

            foreach ($this->data as $key => $values) {
                $result[] = array_combine($keys, str_getcsv($values, $this->conversion['delimiter'], $this->conversion['enclosure'], $this->conversion['escape']));
            }

            return json_encode($result, $bitmask);
        } else {
            throw new \Exception("Invalid data given");
        }
    }
}
