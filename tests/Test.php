<?php

class Test extends PHPUnit_Framework_TestCase {

	protected function file($name, $content)
	{
		$dir = sys_get_temp_dir();

		$file = join('/', [$dir, $name]);

		file_put_contents($file, $content);

		return [
			'dir' => $dir,
			'name' => $name,
			'path' => $file,
		];
	}
}
