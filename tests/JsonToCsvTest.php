<?php

namespace Pearl\CsvJsonConverter\Tests;

use Pearl\CsvJsonConverter\Type\JsonToCsv;
use PHPUnit\Framework\TestCase;

class JsonToCsvTest extends TestCase
{
    /**
     * @return \Pearl\CsvJsonConverter\Type\JsonToCsv
     */
    private function initObj($data = null, $options = []) : JsonToCsv
    {
        return new JsonToCsv($data, $options);
    }

    public function testLoadFile()
    {
        $jsonToCsv = $this->initObj()->load($filePath = __Dir__ . '/data/products.json');
        $this->assertFileExists($filePath);
        $this->assertEquals('products', $jsonToCsv->getFileName());
    }

    public function testJsonInject()
    {
        $jsonToCsv = $this->initObj($this->getSampleData());
        $this->assertArrayHasKey('name', $jsonToCsv->getData()[0]);
    }

    public function testArrayInject()
    {
        $jsonToCsv = $this->initObj(json_decode($this->getSampleData(), true));
        $this->assertArrayHasKey('name', $jsonToCsv->getData()[0]);
    }

    public function testConvertAndSave()
    {
        $jsonToCsv = $this->initObj($this->getSampleData());
        $path = __Dir__ . '/output';
        $jsonToCsv->convertAndSave($path);
        $this->assertFileExists($path . '.csv');
    }

    public function testConvertAndDownload()
    {
        $jsonToCsv = $this->initObj($this->getSampleData());
        $jsonToCsv->convertAndDownload(null, false);
        $this->expectOutputRegex('/"My Journey: Transforming Dreams into Actions","A.P.J. Abdul Kalam","Rupa Publications",en\\n/');
    }

    public function testCustomHeader()
    {
        $jsonToCsv = $this->initObj($this->getSampleData(), ["headers" => $this->getHeaders()]);
        $result = $jsonToCsv->convert();
        $header = explode(PHP_EOL, $result);
        $this->assertEquals(implode($this->getHeaders(), ','), $header[0]);
    }

    private function getSampleData()
    {
        return '[
            {
                "name" : "Half Girlfriend",
                "author" : "Chetan Bhagat",
                "publisher" : "Rupa Publications",
                "language" : "en"
            },
            {
                "name" : "My Journey: Transforming Dreams into Actions",
                "author" : "A.P.J. Abdul Kalam",
                "publisher" : "Rupa Publications",
                "language" : "en"
            }
        ]';
    }

    private function getHeaders()
    {
        return [
            "itemName", 
            "itemAuthor", 
            "itemPublisher", 
            "itemLanguage"
        ];
    }
}