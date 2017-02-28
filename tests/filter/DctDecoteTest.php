<?php

declare(strict_types=1);

use dataplan\pdfStreamDecode\filter\dct_decode;

/**
 * @covers dataplan\pdfStreamDecode\filter\dct_decode
 */
class DctDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new dct_decode([], []);

		$input = 'such jpg, very lossy, wow';

		$result = $filter->decode($input);

		$this->assertSame($input, $result);
	}

}
