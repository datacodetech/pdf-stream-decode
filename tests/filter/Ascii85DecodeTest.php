<?php

declare(strict_types=1);

use datacode\pdfStreamDecode\filter\ascii85_decode;

/**
 * @covers datacode\pdfStreamDecode\filter\ascii85_decode
 */
class ASCII85DecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new ascii85_decode([], []);

		$input = 'GAh[JF*1u++EMXFBl7P';
		$expected_result = 'wow such string';

		$this->assertSame($expected_result, $filter->decode($input));
	}

}
