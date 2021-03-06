<?php

class RenderEntities extends AccountSubclass implements RendererInterface {

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$entityLoader = new EntityLoader($this->account());
		return $entityLoader->entitiesJson();
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	public function usesBox() {
		return false;
	}
}