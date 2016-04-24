<?php

class Sector_OldBattlefield extends Sector_Abstract {
	const KEY = 2;

	/**
	 * @return string
	 */
	public function name() {
		return 'oldBattlefield';
	}

	/**
	 * @param Starbase $starbase
	 */
	protected function addModules(Starbase $starbase) {
		$starbase
			->addModule(new Starbase_Module_Quarters())
			->addModule(new Starbase_Module_JumpGate())
			->addModule(new Starbase_Module_Bank())
			->addModule(new Starbase_Module_Factory()) // 7
			->addModule(new Starbase_Module_Hangar())
			->addModule(new Starbase_Module_Skirmish());
	}

	/**
	 * @return int[]
	 */
	public function starTravelItems() {
		return array(
			SPACE_JUNK_ID			=> 30,
			IRON_ID					=> 45,	// 15%
			PLASTICS_ID				=> 55,	// 10%
			TOXIC_WASTE_ID			=> 65,	// 10%
			ENERGY_CELLS_ID			=> 80,	// 15%
			TECHNICAL_COMPONENTS_ID	=> 90,	// 10%
			ELECTRONICS_ID			=> 100	// 10%
		);
	}

	/**
	 * @return int
	 */
	public function x() {
		return 180;
	}

	/**
	 * @return int
	 */
	public function y() {
		return 200;
	}

	/**
	 * @return int
	 */
	public function unlockPrice() {
		return 0;
	}

	/**
	 * @return int
	 */
	public function unlockLevel() {
		return 0;
	}
}