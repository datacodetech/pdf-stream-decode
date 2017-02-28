<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode\filter;

use Tuupola\Base85;

use dataplan\pdfStreamDecode\filter;

class ascii85_decode extends filter {

	/**
	 * @param array $stream_params Input variables attached to the stream object
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $stream_params, array $decode_params) {
		parent::__construct('ASCII85Decode', $stream_params, $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): string {
		return (new Base85())->decode($data);
	}

}
