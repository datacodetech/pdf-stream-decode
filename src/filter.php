<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode;

abstract class filter {

	protected $name;
	protected $decode_params;

	/**
	 * @param string $name The filter name
	 * @param array $decode_params Input variables for the decode function
	 */
	public function __construct(string $name, array $decode_params) {
		$this->name = $name;
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
			'ASCII85Decode' => ascii85_decode::class,
			'ASCIIHexDecode' => ascii_hex_decode::class,
			'FlateDecode' => flate_decode::class,
			'LZWDecode' => lzw_decode::class,
			'RunLengthDecode' => run_length_decode::class,
			'DCTDecode' => dct_decode::class,
			'CCITTFaxDecode' => ccitt_fax_decode::class,
			'JBIG2Decode' => jbig2_decode::class,
			'JPXDecode' => jpx_decode::class,
		];
	}

	/**
	 * Creates a instance of a filter by name
	 *
	 * @param string $name The name of the filter
	 * @param array $decode_params Input variables for the decode function
	 *
	 * @return filter The filter instance
	 */
	public static function get_by_name(string $name, array $decode_params): filter {
		$class_map = self::get_class_map();

		if (!array_key_exists($name, $class_map)) {
			throw new \Exception('No filter is defined with the name ' . $name);
		}

		$class_name = $class_map[$name];

		return new $class_name($decode_params);
	}

}
