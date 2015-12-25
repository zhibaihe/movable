<?php

namespace Zhibaihe\Movable;

class Compiler {

	/**
	 * Compile the Movable template source into PHP
	 * @param  string $source Movable template source
	 * @return string         Compiled PHP
	 */
	public function compile($source)
	{
		$content = preg_replace('/\{\{[\s]*([^\s].*[^\s])[\s]*\}\}/', '<?php echo $1; ?>', $source);

		$content = preg_replace_callback("/@(\w+)\(([^)]+)\)/", function($matches){
			$function = $matches[1];
			$params = $matches[2];

			return "<?php \$_f->$function($params); ?>";
		}, $content);

		$content = preg_replace_callback("/([^@])@end(\w+)/", function($matches){
			$holder = $matches[1];
			$function = 'end' . ucfirst($matches[2]);

			return "$holder<?php \$_f->$function(); ?>";
		}, $content);

		return $content;
	}

}