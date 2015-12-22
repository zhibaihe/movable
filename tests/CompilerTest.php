<?php

use Zhibaihe\Movable\Compiler;

class CompilerTest extends PHPUnit_Framework_TestCase
{

	protected $compiler;

	public function setUp()
	{
		$this->compiler = new Compiler;
	}

	/** @test */
	public function it_can_be_initialized()
	{
		$this->assertInstanceOf(Compiler::class, $this->compiler);
	}

	/** @test */
	public function it_compiles_echo_statements()
	{
		$result = $this->compiler->compile('Hello, {{ $world }}');

		$this->assertEquals('Hello, <?php echo $world; ?>', $result);

		$result = $this->compiler->compile('Hello, {{ date("Y-m-d") }}');

		$this->assertEquals('Hello, <?php echo date("Y-m-d"); ?>', $result);

		$result = $this->compiler->compile('Hello, {{$a && $b}}');

		$this->assertEquals('Hello, <?php echo $a && $b; ?>', $result);
	}
}

