# PDF Stream Decode
PHP library to decode the data in PDF stream objects

## Installation
Include with composer by adding
~~~json
{
	"type": "vcs",
	"url": "git@git.dataplan.co.uk:jacek/pdf-stream-decode.git"
}
~~~
to the repositories section then use this as a dependency
~~~json
{
	"require": {
		"dataplan/pdf-stream-decode": "dev-master"
	}
}
~~~

## Usage
This has been designed to work with [pdfparser](https://packagist.org/packages/smalot/pdfparser) although any source can be used if the input is in the same format - the data from the PDF object header as an assoc array.

~~~php
<?php

use Smalot\PdfParser\Parser;
use dataplan\pdfStreamDecode\stream;

$parser = new Parser();

$page = $parser->getPages()[0];
$object = $page->getXObjects()[0];

$object_details = $object->getDetails();
$object_data = $object->getContent();

$decoded_data = (new stream($object_details, $object_data))->decode();
~~~
`$object_details` may also be constructed manually if pdfparser is not used
~~~php
<?php

$object_details = [
	'Filter' => 'FlateDecode',
	'Length' => 12349,
];
~~~
