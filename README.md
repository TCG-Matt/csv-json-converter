[![Build Status](https://travis-ci.org/pearlkrishn/csv-json-converter.svg?branch=master)](https://travis-ci.org/pearlkrishn/csv-json-converter)

# Convert CSV to JSON and JSON to CSV using PHP.

## Installation

   `composer require pearl/csv-json-converter`
 
 ## How to use?

 ### JSON to CSV:
 ##### Sample Json Data:
 ```php
 $jsonString = '[{
	 "name": "Half Girlfriend",
	 "author": "Chetan Bhagat",
	 "publisher": "Rupa Publications",
	 "language": "en"
},
{
	 "name": "My Journey: Transforming Dreams into Actions",
	 "author": "A.P.J. Abdul Kalam",
	 "publisher": "Rupa Publications",
	 "language": "en"
}]';
 ```

```php
use Pearl\CsvJsonConverter\Type\JsonToCsv;	
```

##### Data loading: 

- Array or Json values are accepted.
- Custom output header optional available. This is optional parameter if not passed then default header will be considered.

```php
$jsonToCsv = new JsonToCsv($jsonString, ['headers' => ["productName", "author", "publisher", "lang"]]);
```
Or load the json data from file.

```php
$jsonToCsv->load(__Dir__ . '/data/products.json');
```
##### Data conversion result options :
```php
<!-- Convert and save the result to specificed path -->
$jsonToCsv->convertAndSave(__Dir__ . '/output');

<!-- Convert and force download the file in browser-->
$jsonToCsv->convertAndDownload(__Dir__ . '/output');

<!-- Convert and get data-->
$jsonToCsv->convert();

```
#### Output:
|  name |  author |  publisher |  language |
| ------------ | ------------ | ------------ | ------------ |
|  Half Girlfriend |  Chetan Bhagat | Rupa Publications  | en  |
|  My Journey: Transforming Dreams into Actions | A.P.J. Abdul Kalam  | Rupa Publications  |  en |

### CSV to JSON:

```php
use Pearl\CsvJsonConverter\Type\CsvToJson;
```
Load the CSV data.
```php
$csvToJson = new CsvToJson($csvString, ['bitmask' => 'JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES']);
```
Or Load the csv data from file.
```php
$csvToJson->load(__Dir__ . '/data/products.csv');
```
##### Data conversion result options :
```php
<!-- Convert and save to specificed path -->
$csvToJson->convertAndSave(__Dir__ . '/output');

<!-- Convert and force download the file-->
$csvToJson->convertAndDownload(__Dir__ . '/output');

<!-- Convert and get data-->
$csvToJson->convert();

```
#### Sample Csv:

|  name |  author |  publisher |  language |
| ------------ | ------------ | ------------ | ------------ |
|  Half Girlfriend |  Chetan Bhagat | Rupa Publications  | en  |
|  My Journey: Transforming Dreams into Actions | A.P.J. Abdul Kalam  | Rupa Publications  |  en |

#### Output:
```json
  [{
  		"name": "Half Girlfriend",
  		"author": "Chetan Bhagat",
  		"publisher": "Rupa Publications",
  		"language": "en"
  	},
  	{
  		"name": "My Journey: Transforming Dreams into Actions",
  		"author": "A.P.J. Abdul Kalam",
  		"publisher": "Rupa Publications",
  		"language": "en"
  	}
  ]
```
