<?php

declare(strict_types=1);

namespace dataplan\pdfStreamDecode;

class stream {

	private $filter_names;
	private $stream_params;
	private $decode_params;
	private $data;

	private $filters;
	private $decoded;

	/**
	 * @param array $stream_params An assoc array of params attached to the stream
	 * @param string $data The input data
	 */
	public function __construct(array $stream_params, string $data) {
		$this->filter_names = $stream_params['Filter'];
		$this->stream_params = $stream_params;
		$this->decode_params = ($stream_params['DecodeParms'] ?? []);
		$this->data = $data;

		$this->filters = [];
		$this->decoded = null;

		unset($this->stream_params['Filter'], $this->stream_params['DecodeParms']);

		if (!is_array($this->filter_names)) {
			$this->filter_names = [ $this->filter_names ];
			$this->decode_params = [ $this->filter_names[0] => $this->decode_params ];
		}

		foreach ($this->filter_names as $name) {
			$this->filters[] = filter::get_by_name($name, $this->stream_params, $this->decode_params[$name]);
		}
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
