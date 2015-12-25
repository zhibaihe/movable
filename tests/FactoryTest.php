<?php

use Zhibaihe\Movable\Factory;

class FactoryTest extends Test {

	protected $factory;

	/** @before */
	public function prepare()
	{
		$this->factory = new Factory;
	}

	/** @test */
	public function it_can_be_initialized()
	{
		$this->assertInstanceOf(Factory::class, $this->factory);
	}

	/** @test */
	public function it_assembles_views()
	{
		$parent = $this->file('parent.mov.php', 'parent <?php $_f->blank("widget"); ?> parent');
		$child = $this->file('child.mov.php', '<?php $_f->inherit("parent"); ?><?php $_f->fill("widget"); ?><?php echo $me; ?><?php $_f->endFill();?>');

		$this->factory->setBase($parent['dir']);

		$result = $this->factory->make('child', ['me' => 'child']);

		$this->assertEquals('parent child parent', $result);
	}
}