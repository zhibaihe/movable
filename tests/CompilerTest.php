<?php

use Zhibaihe\Movable\Compiler;

class CompilerTest extends Test
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

	/** @test */
	public function it_compiles_blank_statement()
	{
		$result = $this->compiler->compile("hello, @blank(\"name\"), @blank(\"mark\")");

		$this->assertEquals('hello, <?php $_f->blank("name"); ?>, <?php $_f->blank("mark"); ?>', $result);
	}

	/** @test */
	public function it_compiles_fill_statement()
	{
		$result = $this->compiler->compile("a, @fill(\"name\")\nBlock content\n@endfill\nb.");

		$this->assertEquals("a, <?php \$_f->fill(\"name\"); ?>\nBlock content\n<?php \$_f->endFill(); ?>\nb.", $result);
	}
}

