<?php

namespace Zhibaihe\Movable;

class Factory {

	protected $base;

	protected $data;

	protected $views = [];

	protected $blanks = [];

	public function setBase($base)
	{
		$this->base = $base;
	}

	public function make($view, $data)
	{
		$this->data = array_merge($data, [
			'_f' => $this,
		]);

		$this->views[$view] = $this->render($view, $this->data);

		foreach ($this->views as $view => $content) {
			if (count($this->blanks) > 0) {
				foreach ($this->blanks as $name => $fill) {
					$this->views[$view] = \preg_replace('/'. $this->placeholder('blank', $name) .'/', $fill, $this->views[$view]);
				}
			}
		}

		return join('', $this->views);
	}

	public function render($view, $data)
	{
		$path = $this->getViewPath($view);

		ob_start();

		extract($data);

		include($path);

		$result = ob_get_contents();

		ob_end_clean();

		return $result;
	}

	public function inherit($view)
	{
		if ( ! array_key_exists($view, $this->views)) {
			$this->views[$view] = $this->render($view, $this->data);
		}
	}

	public function blank($name)
	{
		if ( ! array_key_exists($name, $this->blanks)) {
			$this->blanks[$name] = '';
		}

		echo $this->placeholder('blank', $name);
	}

	public function fill($name)
	{
		$this->currentBlock = $name;
		ob_start();
	}

	public function endFill()
	{
		$content = ob_get_contents();

		ob_end_clean();

		$this->blanks[$this->currentBlock] = $content;
	}

	protected function placeholder($type, $name)
	{
		return "%mov-- $type $name --mov%";
	}

	protected function getViewPath($view)
	{
		return join('/', [$this->base, "$view.mov.php"]);
	}
}