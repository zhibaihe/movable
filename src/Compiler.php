<?php

namespace Zhibaihe\Movable;

class Compiler {

	public function __construct()
	{
		
	}

	public function compile($source)
	{
		return preg_replace('/\{\{[\s]*([^\s].*[^\s])[\s]*\}\}/', '<?php echo $1; ?>', $source);
	}

}