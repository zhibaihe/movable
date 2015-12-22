<?php

namespace Zhibaihe\Movable;

class View {

	public function render($filepath, $data) {
		ob_start();

		extract($data);

		include($filepath);

		$result = ob_get_contents();

		ob_end_clean();

		return $result;
	}
}