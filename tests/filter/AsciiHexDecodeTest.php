<?php

declare(strict_types=1);

use dataplan\pdfStreamDecode\filter\ascii_hex_decode;

/**
 * @covers dataplan\pdfStreamDecode\filter\ascii_hex_decode
 */
class ASCIIHexDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new ascii_hex_decode([]);

		$input = '776f77207375636820737472696e67';
		$expected_result = 'wow such string';

		$this->assertSame($expected_result, $filter->decode($input));
	}

}
