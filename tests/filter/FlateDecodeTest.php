<?php

declare(strict_types=1);

use datacode\pdfStreamDecode\filter\flate_decode;

/**
 * @covers datacode\pdfStreamDecode\filter\flate_decode
 */
class FlateDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new flate_decode([], []);

		$expected_result = 'such compress, very gzip';
		$input = gzcompress($expected_result);

		if ($input === false) {
			throw new \Exception('Failed to compress input data');
		}

		$actual_result = $filter->decode($input);

		$this->assertInternalType('string', $actual_result);
		$this->assertSame($expected_result, $actual_result);
	}

	public function testDecodeInvalid() {
		$filter = new flate_decode([], []);

		// A document with a stream that is known to fail when being decoded
		$pdf_path = $this->getDataFilePath('pdf', 'invalid_gzip_stream.pdf');
		$pdf_data = file_get_contents($pdf_path);

		$parser = new \Smalot\PdfParser\Parser();
		$document = $parser->parseContent($pdf_data);
		$pages = $document->getPages();
		$objects = $pages[0]->getXObjects();

		$objects = array_filter($objects, function ($object) {
			return $object->getDetails()['Filter'] === 'FlateDecode';
		});

		// This stream is known to fail
		$object = $objects[0];
		$details = $object->getDetails();
		$stream_data = $object->cleanContent($object->getContent());

		$result = $filter->decode($stream_data);

		// Should have failed
		$this->assertSame(null, $result);
	}

}
