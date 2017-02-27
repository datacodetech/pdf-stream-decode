<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode\filter;

use dataplan\pdfStreamDecode\filter;

class lzw_decode extends filter {

	/**
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $decode_params) {
		parent::__construct('LZWDecode', $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): string {
		// Wrap FPDI https://github.com/Setasign/FPDI/blob/master/filters/FilterLZW.php
		return (new \FilterLZW())->decode($data);
	}

}
