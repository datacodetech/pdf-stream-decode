<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode;

use dataplan\pdfStreamDecode\filter\ascii85_decode;
use dataplan\pdfStreamDecode\filter\ascii_hex_decode;
use dataplan\pdfStreamDecode\filter\flate_decode;
use dataplan\pdfStreamDecode\filter\lzw_decode;
use dataplan\pdfStreamDecode\filter\run_length_decode;
use dataplan\pdfStreamDecode\filter\dct_decode;
use dataplan\pdfStreamDecode\filter\ccitt_fax_decode;
use dataplan\pdfStreamDecode\filter\jbig2_decode;
use dataplan\pdfStreamDecode\filter\jpx_decode;

abstract class filter {

	protected $name;
	protected $stream_params;
	protected $decode_params;

	/**
	 * @param string $name The filter name
	 * @param array $stream_params An assoc array of params attached to the stream
	 * @param array $decode_params Input variables for the decode function
	 */
	public function __construct(string $name, array $stream_params, array $decode_params) {
		$this->name = $name;
		$this->stream_params = $stream_params;
		$this->decode_params = $decode_params;
	}

	/**
	 * Gets the name of this filter
	 *
	 * @return string The name
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * Decodes data using this filter
	 *
	 * @param string $data The input data
	 *
	 * @return string The result
	 */
	abstract public function decode(string $data): string;

	/**
	 * Gets a map of filter names to the class that implements them
	 *
	 * @return array The map
	 */
	public static function get_class_map(): array {
		return [
			'ASCIIHexDecode' => ascii_hex_decode::class,
			'ASCII85Decode' => ascii85_decode::class,
			'CCITTFaxDecode' => ccitt_fax_decode::class,
			'DCTDecode' => dct_decode::class,
			'FlateDecode' => flate_decode::class,
			'JBIG2Decode' => jbig2_decode::class,
			'JPXDecode' => jpx_decode::class,
			'LZWDecode' => lzw_decode::class,
			'RunLengthDecode' => run_length_decode::class,
		];
	}

	/**
	 * Creates a instance of a filter by name
	 *
	 * @param string $name The name of the filter
	 * @param array $stream_params Variables attached to the stream object, excluding Filter and DecodeParms
	 * @param array $decode_params Input variables for the decode function
	 *
	 * @return filter The filter instance
	 */
	public static function get_by_name(string $name, array $stream_params, array $decode_params): filter {
		$class_map = self::get_class_map();

		if (!array_key_exists($name, $class_map)) {
			throw new \Exception('No filter is defined with the name ' . $name);
		}

		$class_name = $class_map[$name];

		return new $class_name($stream_params, $decode_params);
	}

}
