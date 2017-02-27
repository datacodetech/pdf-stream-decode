<?php

declare(strict_types=1);

use dataplan\pdfStreamDecode\filter\flate_decode;

class FlateDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new flate_decode([]);

		$expected_result = 'such compress, very gzip';
		$input = gzcompress($expected_result);

		if ($input === false) {
			throw new \Exception('Failed to compress input data');
		}

		$actual_result = $filter->decode($input);

		$this->assertInternalType('string', $actual_result);
		$this->assertSame($expected_result, $actual_result);
	}

}
