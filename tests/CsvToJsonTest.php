<?php

namespace Pearl\CsvJsonConverter\Tests;

use Pearl\CsvJsonConverter\Type\CsvToJson;
use PHPUnit\Framework\TestCase;

class CsvToJsonTest extends TestCase
{
    /**
     * @return \Pearl\CsvJsonConverter\Type\CsvToJson
     */
    private function initObj($data = null, $options = []) : CsvToJson
    {
        return new CsvToJson($data, $options);
    }

    public function testLoadFile()
    {
        $csvTojson = $this->initObj()->load($filePath = __Dir__ . '/data/products.csv');
        $this->assertFileExists($filePath);
        $this->assertEquals('products', $csvTojson->getFileName());
    }

    public function testCsvInject()
    {
        $csvTojson = $this->initObj($this->getSampleData());
        $this->assertEquals('name,author,publisher,language', $csvTojson->getData()[0]);
    }

    public function testConvertAndGetRaw()
    {
        $csvTojson = $this->initObj($this->getSampleData());
        $this->assertEquals('[{"name":"Half Girlfriend","author":"Chetan Bhagat","publisher":"Rupa Publications","language":"en"},{"name":"My Journey: Transforming Dreams into Actions","author":"A.P.J. Abdul Kalam","publisher":"Rupa Publications","language":"en"}]', $csvTojson->convert());
    }

    public function testConvertAndSave()
    {
        $csvTojson = $this->initObj($this->getSampleData());
        $path = __Dir__ . '/output';
        $csvTojson->convertAndSave($path);
        $this->assertFileExists($path . '.json');
    }

    public function testConvertAndDownload()
    {
        $csvTojson = $this->initObj($this->getSampleData());
        $csvTojson->convertAndDownload(null, false);
        $this->expectOutputRegex('[{"name":"Half Girlfriend","author":"Chetan Bhagat","publisher":"Rupa Publications","language":"en"},{"name":"My Journey: Transforming Dreams into Actions","author":"A.P.J. Abdul Kalam","publisher":"Rupa Publications","language":"en"}]');
    }

    private function getSampleData()
    {
        return file_get_contents(__Dir__ . '/data/products.csv');
    }
}