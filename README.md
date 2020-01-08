# PDF Stream Decode
PHP library to decode the data in PDF stream objects.

## Installation
Include with composer by adding
~~~json
{
	"require": {
		"datacodetech/pdf-stream-decode": "^1.0.0"
	}
}
~~~

## Usage
This has been designed to work with [pdfparser](https://packagist.org/packages/smalot/pdfparser) although any source
can be used if the input is in the same format - the data from the PDF object header as an assoc array.

~~~php
<?php

use Smalot\PdfParser\Parser;
use datacode\pdfStreamDecode\stream;

$parser = new Parser();

$document = $parser->parseContent(file_get_contents('pdf_file.pdf'));

$page = $document->getPages()[0];
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
