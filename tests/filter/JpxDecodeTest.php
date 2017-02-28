<?php

declare(strict_types=1);

use dataplan\pdfStreamDecode\filter\jpx_decode;

class JpxDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new jpx_decode([], []);

		$input = 'such jpeg, very 2000, wow';

		$result = $filter->decode($input);

		$this->assertSame($input, $result);
	}

}
