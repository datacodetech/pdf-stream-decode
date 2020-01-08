<?php

declare(strict_types=1);

use betterphp\utils\reflection;

use datacode\pdfStreamDecode\stream;
use datacode\pdfStreamDecode\filter;
use datacode\pdfStreamDecode\filter\ccitt_fax_decode;

class StreamTest extends StreamDecodeTestCase {

	public function testCreate() {
		$expected_filter_names = [
			'CCITTFaxDecode',
		];

		$expected_decode_params = [
			$expected_filter_names[0] => [
				'Rows' => 100,
				'columns' => 12,
				'K' => -1,
			],
		];

		$expected_stream_params = [
			'Length' => 1024,
		];

		$expected_data = 'such data, very stream';

		$input_spec = array_merge(
			$expected_stream_params,
			[ 'Filter' => $expected_filter_names[0] ],
			[ 'DecodeParms' => $expected_decode_params[$expected_filter_names[0]] ]
		);

		$stream = new stream($input_spec, $expected_data);

		$actual_filter_names = reflection::get_property($stream, 'filter_names');
		$actual_stream_params = reflection::get_property($stream, 'stream_params');
		$actual_decode_params = reflection::get_property($stream, 'decode_params');
		$actual_data = reflection::get_property($stream, 'data');
		$actual_filters = reflection::get_property($stream, 'filters');

		$this->assertSame($expected_filter_names, $actual_filter_names);
		$this->assertSame($expected_stream_params, $actual_stream_params);
		$this->assertSame($expected_decode_params, $actual_decode_params);
		$this->assertSame($expected_data, $actual_data);

		$this->assertCount(1, $actual_filters);
		$this->assertInstanceOf(ccitt_fax_decode::class, $actual_filters[0]);
	}

	public function testDecode() {
		$input_data = 'such data, very input, wow';

		$stream = new stream([], $input_data);

		$first_filter = $this
			->getMockBuilder(filter::class)
			->setConstructorArgs([ 'test', [], [] ])
			->getMockForAbstractClass();

		$second_filter = $this
			->getMockBuilder(filter::class)
			->setConstructorArgs([ 'test', [], [] ])
			->getMockForAbstractClass();

		$first_filter
			->expects($this->at(0))
			->method('decode')
			->with($input_data)
			->willReturn($input_data);

		$second_filter
			->expects($this->at(0))
			->method('decode')
			->with($input_data)
			->willReturn($input_data);

		reflection::set_property($stream, 'filters', [ &$first_filter, &$second_filter ]);

		$result = $stream->decode();

		$this->assertSame($input_data, $result);
	}

}
