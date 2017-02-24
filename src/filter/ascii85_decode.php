<?php

declare(strict_types=1);

use dataplan\pdfStreamDecode\filter;

namespace dataplan\pdfStreamDecode\filter;

class ascii85_decode extends filter {

	/**
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $decode_params) {
		parent::__construct('', $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): string {
		throw new \Exception('Not yet implemented');
	}

}
