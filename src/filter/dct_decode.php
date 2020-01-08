<?php

declare(strict_types=1);

namespace datacode\pdfStreamDecode\filter;

use datacode\pdfStreamDecode\filter;

class dct_decode extends filter {

	/**
	 * @param array $stream_params Input variables attached to the stream object
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $stream_params, array $decode_params) {
		parent::__construct('DCTDecode', $stream_params, $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): ?string {
		// Raw JPG data, just return
		return $data;
	}

}
