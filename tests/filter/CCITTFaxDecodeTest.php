<?php

declare(strict_types=1);

use datacode\pdfStreamDecode\filter\ccitt_fax_decode;

/**
 * @covers datacode\pdfStreamDecode\filter\ccitt_fax_decode
 */
class CCITTFaxDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new ccitt_fax_decode([
			'Width' => 0,
			'Height' => 0,
			'EncodedByteAlign' => false,
			'Length' => 1024,
			'BitsPerComponent' => 1,
		], [
			'K' => -1,
			'Columns' => 0,
			'Rows' => 0,
		]);

		$input = 'tiff_data';

		$result = $filter->decode($input);

		$this->assertNotEmpty($result);
		$this->assertContains($input, $result);
	}

	public function testDecodeFile() {
		$pdf_path = $this->getDataFilePath('pdf', 'ccitt_fax_t6.pdf');
		$pdf_data = file_get_contents($pdf_path);

		$parser = new \Smalot\PdfParser\Parser();
		$document = $parser->parseContent($pdf_data);

		$pages = $document->getPages();
		$objects = $pages[0]->getXObjects();

		$objects = array_filter($objects, function ($object) {
			return $object->getDetails()['Subtype'] === 'Image';
		});

		$object = array_shift($objects);
		$details = $object->getDetails();
		$stream_data = $object->getContent();

		// Test file has the size in a separate object
		$details['Length'] = $details['Length'][0];

		$filter = new ccitt_fax_decode($details, $details['DecodeParms']);

		$result = $filter->decode($stream_data);

		// Included the stream data and added something
		$this->assertContains($stream_data, $result);
		$this->assertGreaterThan(strlen($stream_data), strlen($result));
	}

}
