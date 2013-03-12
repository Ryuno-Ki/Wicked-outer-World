<?php

class ControllerLogin extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderLogin
	 */
	public function renderer($section) {
		$renderer = new RenderLogin();

		return $renderer->setController($this);
	}
}