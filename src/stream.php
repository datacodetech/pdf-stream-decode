<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode;

class stream {

	protected $filters;

	private $data;
	private $decoded;

	/**
	 * @param array $filter_names A list of filter names
	 * @param array $decode_params The decode_params from the PDF header
	 * @param string $data The input data
	 */
	public function __construct(array $filter_names, array $decode_params, string $data) {
		$this->filters = [];

		foreach ($filter_names as $name) {
			$this->filters[] = filter::get_by_name($name, $decode_params[$name]);
		}

		$this->decode_params = $decode_params;
		$this->data = $data;
		$this->decoded = null;
	}

	/**
	 * Decodes the data in the stream and returns it as a string
	 *
	 * This method will only decode the input data once, subsequent calls will return a cached value
	 *
	 * @return string The data
	 */
	public function decode(): string {
		if ($this->decoded === null) {
			$this->decoded = $this->data;

			foreach ($this->filters as $filter) {
				$this->decoded = $filter->decode($this->decoded);
			}
		}

		return $this->decoded;
	}

}
