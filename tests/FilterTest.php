<?php

declare(strict_types=1);

use betterphp\utils\reflection;

use datacode\pdfStreamDecode\filter;

/**
 * @covers datacode\pdfStreamDecode\filter
 */
class FilterTest extends StreamDecodeTestCase {

	public function testGetProperties() {
		$expected_name = 'such name, very filter';
		$expected_stream_params = ['very' => 'params', 'such' => 'stream'];
		$expected_decode_params = ['very' => 'params', 'such' => 'decode'];

		$filter = $this
			->getMockBuilder(filter::class)
			->setConstructorArgs([$expected_name, $expected_stream_params, $expected_decode_params])
			->getMockForAbstractClass();

		$actual_name = reflection::get_property($filter, 'name');
		$actual_stream_params = reflection::get_property($filter, 'stream_params');
		$actual_decode_params = reflection::get_property($filter, 'decode_params');

		$this->assertSame($expected_name, $actual_name);
		$this->assertSame($expected_stream_params, $actual_stream_params);
		$this->assertSame($expected_decode_params, $actual_decode_params);

		$this->assertSame($expected_name, $filter->get_name());
	}

	public function testGetClassMap() {
		$class_map = filter::get_class_map();

		$this->assertInternalType('array', $class_map);
	}

	public function testGetByName() {
		$filter = filter::get_by_name('FlateDecode', [], []);

		$this->assertInstanceOf(filter::class, $filter);
	}

	public function testGetByNameWithInvalidName() {
		$invalid_name = 'probably_nothing_called_this';

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage("No filter is defined with the name {$invalid_name}");

		filter::get_by_name($invalid_name, [], []);
	}

}
