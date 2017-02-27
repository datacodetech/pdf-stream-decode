<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode\filter;

use dataplan\pdfStreamDecode\filter;

class ccitt_fax_decode extends filter {

	/**
	 * @param array $decode_params Input params for the decode function
	 */
	public function __construct(array $decode_params) {
		parent::__construct('CCITTFaxDecode', $decode_params);
	}

	/**
	 * @inheritDoc
	 */
	public function decode(string $data): string {
		$width = ($this->decode_params['Width'] ?? $this->decode_params['W'] ?? 1728);
		$height = ($this->decode_params['Height'] ?? $this->decode_params['H'] ?? 0);

		$columns = ($this->decode_params['Columns'] ?? $width);
		$rows = ($this->decode_params['Rows'] ?? $height);

		$k = ($this->decode_params['K'] ?? 0);
		$align = (bool) ($this->decode_params['EncodedByteAlign'] ?? false);

		$length = (int) $this->decode_params['Length'];
		$bits_per_component = (int) ($this->decode_params['BitsPerComponent'] ?? 1);

		$ccitt_group = 4;

		if ($k > 0) { // T42D
			$compression = 3;
		} else if ($k === 0) { // T41D
			$compression = 2;
		} else if ($k < 0) { // T6
			$compression = 4;
		} else {
			throw new \Exception('Invalid K value ' . $k);
		}

		/*
		1 = BYTE 8-bit unsigned integer.
		2 = ASCII 8-bit byte that contains a 7-bit ASCII code; the last byte must be NUL (binary zero).
		3 = SHORT 16-bit (2-byte) unsigned integer.
		4 = LONG 32-bit (4-byte) unsigned integer.
		5 = RATIONAL Two LONGs: the first represents the numerator of a fraction; the second, the denominator.
		*/

		// TIFF spec https://www.itu.int/itudoc/itu-t/com16/tiff-fx/docs/tiff6.pdf
		$header_fields = [
			// Data type for pack() followed by what to add
			['aa', 'I', 'I'],
			['v', 42],
			['V', 8],
			// Begin IFD
			['v', 8],
			['vvVV', 256, 4, 1, $columns], // ImageWidth
			['vvVV', 257, 4, 1, $rows], // ImageLength
			['vvVV', 258, 3, 1, $bits_per_component], // BitsPerSample
			['vvVV', 259, 3, 1, $compression], // Compression // ??
			['vvVV', 262, 3, 1, 0], // Threshholding
			['vvVV', 273, 4, 1, (2 + 2 + 4 + 2 + (12 * 8) + 4)], // StripOffsets
			['vvVV', 278, 4, 1, $rows], // RowsPerStrip
			['vvVV', 279, 4, 1, $length], // StripByteCounts
			// End IFD
			['V', 0], // Next IFD
		];

		$format = '';
		$args = [];

		foreach ($header_fields as $field) {
			$format .= array_shift($field);

			foreach ($field as $arg) {
				$args[] = $arg;
			}
		}

		$header_data = call_user_func_array('pack', array_merge([$format], $args));

		return $header_data . $data;
	}

}
