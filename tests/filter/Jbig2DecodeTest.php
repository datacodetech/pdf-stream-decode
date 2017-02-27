<?php

declare(strict_types=1);

use dataplan\pdfStreamDecode\filter\jbig2_decode;

class Jbig2DecodeTest extends StreamDecodeTestCase {

	public function testDecode() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Not yet implemented');

		$filter = new jbig2_decode([]);
		$filter->decode('');
	}

}
