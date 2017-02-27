<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class StreamDecodeTestCase extends TestCase {

	/**
	 * Gets the absolute path to a names file in the test-data folder
	 *
	 * @param string $type The type of file, this is one of the subfolders of test-data
	 * @param string $file_name The name of the file
	 *
	 * @return string The file path
	 */
	protected function getDataFilePath(string $type, string $file_name): string {
		return __DIR__ . "/../test-data/{$type}/{$file_name}";
	}

}
