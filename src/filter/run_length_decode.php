<?php

declare(strict_types=1);

namespace datacode\pdfStreamDecode\filter;

use datacode\pdfStreamDecode\filter;

class run_length_decode extends filter {

	/**
	 * @param array $stream_params Input variables attached to the stream object
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $stream_params, array $decode_params) {
		parent::__construct('RunLengthDecode', $stream_params, $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): ?string {
		// Based (heavily) on https://github.com/zendframework/zf1/blob/master/library/Zend/Pdf/Filter/RunLength.php

		$data_length = strlen($data);
		$result = '';
		$offset = 0;

		while ($offset < $data_length) {
			$length = ord($data[$offset]);

			++$offset;

			if ($length === 128) {
				break;
			} else if ($length < 128) {
				++$length;

				$result .= substr($data, $offset, $length);

				$offset += $length;
			} else if ($length > 128) {
				$result .= str_repeat($data[$offset], (257 - $length));

				++$offset;
			}
		}

		return $result;
	}

}
