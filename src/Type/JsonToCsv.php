<?php

namespace Pearl\CsvJsonConverter\Type;

use Pearl\CsvJsonConverter\ConverterAbstract;

class JsonToCsv extends ConverterAbstract
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
            'extension' => 'csv', 
            'type' => 'text/csv'
        ];
    }

    /**
     * Convert the json to array.
     *
     * @param  string|array  $data
     * @return void
    */

    protected function setData($data)
    {
        if (is_array($data)) {
            $this->data = $data;
        } else  {
    	   $this->data = json_decode($data, true); 
        }
    }

    /**
     * Set CSV Header.
     *
     * @param  $fp
    */

    private function setHeader($fp)
    {
        if (empty($this->options['headers']) === false) {
            fputcsv($fp, $this->options['headers']);
        } else {
            fputcsv($fp, array_keys($this->getFlatData(current($this->data))));
        }

        return $fp;
    }

    /**
     * Conver the array to csv.
     *
     * @return  string|\Exception
    */

    public function convert()
    {
        ob_clean();
        if (empty($this->data) === false && is_array($this->data)) {
            $fp = fopen('php://temp', 'w');
            $fp = $this->setHeader($fp);
            foreach($this->data as $key => $values) {
                fputcsv($fp, $this->getFlatData($values));
            }
            rewind($fp);
            $content = stream_get_contents($fp);
            fclose($fp);
            ob_flush();

            return $content;
        } else {
            throw new \Exception("Invalid data given");
        }
    }

    /**
        * Returns a flatted array
        * @return array
    */

    private function getFlatData($values, $prefix = '') : array
    {
        $result = [];

        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->getFlatData($value, $prefix . $key . '_'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }
}