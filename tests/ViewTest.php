<?php

use Zhibaihe\Movable\View;
use Zhibaihe\Movable\Compiler;

class ViewTest extends PHPUnit_Framework_TestCase {

	protected $view;

	public function setUp()
	{
		$this->view = new View;
	}

	/** @test */
	public function it_can_be_initialized()
	{
		$this->assertInstanceOf(View::class, $this->view);
	}

	/** @test */
	public function it_renders_a_simple_standalone_view()
	{
		$template = $this->file('simple.mov.php', '<?php echo $greeting; ?>, <?php echo $name; ?>!');

		$result = $this->view->render($template, ['name' => 'Zhiyan', 'greeting' => 'Hello']);

		$this->assertEquals('Hello, Zhiyan!', $result);
	}

	protected function file($name, $content)
	{
		$dir = sys_get_temp_dir();

		$file = tempnam($dir, $name);

		file_put_contents($file, $content);

		return $file;
	}
}