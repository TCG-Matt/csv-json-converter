<?php

namespace Pearl\CsvJsonConverter;

abstract class ConverterAbstract
{
	/**
     * Raw data.
     *
     * @var  array
    */
    protected $data;

    /**
     * Data Transformation options.
     *
     * @var  array
    */
    protected $options;

    /**
     * conversion details.
     *
     * @var  array
    */
    protected $conversion;

    /**
     * Downloadable filename.
     *
     * @var  string
    */
    protected $fileName;
	
	/**
     * Constructor.
     *
     * @param  string  $data
    */

    public function __construct($data = null, array $options = [])
    {
    	if (!is_null($data))
    		$this->setData($data);
            $this->fileName = time();
        $this->options = $options;
    }

    /**
     * Load the data from file.
     *
     * @param  string  $filePath
     * @return $this
    */

    public function load($filePath)
    {
        $this->fileName = pathinfo($filePath, PATHINFO_FILENAME);
        $this->setData(file_get_contents($filePath));

        return $this;
    }

    /**
     * Get the file name.
     *
     * @return string
    */

    public function getFileName() : string
    {
        return $this->fileName;
    }

    /**
     * Get the data.
     *
     * @return array
    */

    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @param null $fileName
     * @param bool $exit
    */

    public function convertAndDownload($fileName = null, $exit = true)
    {
        header('Content-disposition: attachment; filename=' . ($fileName ?? $this->fileName) . '.' . $this->conversion['extension']);
        header('Content-type: ' . $this->conversion['type']);
        echo $this->convert();
        
        if ($exit === true) {
            exit();
        }
    }

    /**
     * @param string $path
     *
     * @return bool|int
     */
    public function convertAndSave($path) : int
    {
        $fileFullPath = sprintf('%s.%s', $path, $this->conversion['extension']);

        return file_put_contents($fileFullPath, $this->convert());
    }

    abstract public function convert();

    abstract protected function setData($data);
}