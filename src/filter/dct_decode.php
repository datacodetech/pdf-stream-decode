<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode\filter;

use dataplan\pdfStreamDecode\filter;

class dct_decode extends filter {

	/**
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $decode_params) {
		parent::__construct('DCTDecode', $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): string {
		throw new \Exception('Not yet implemented');
	}

}