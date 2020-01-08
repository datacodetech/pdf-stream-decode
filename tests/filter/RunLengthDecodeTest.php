<?php

declare(strict_types=1);

use datacode\pdfStreamDecode\filter\run_length_decode;

/**
 * @covers datacode\pdfStreamDecode\filter\run_length_decode
 */
class RunLengthDecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$filter = new run_length_decode([], []);

		$expected_result = 'AAAABBBBBB123123123';
		$input = chr(257 - 4) . 'A' . chr(257 - 6) . 'B' . "\x08" . '123123123' . "\x80";

		$actual_result = $filter->decode($input);

		$this->assertInternalType('string', $actual_result);
		$this->assertSame($expected_result, $actual_result);
	}

}
