<?php

require_once '../../ext/lisbeth/lisbeth/distributor.php';
require_once '../../ext/lisbeth/lisbeth/entity.php';
require_once '../lib/account.php';
require_once '../lib/accountsubclass.php';
require_once '../lib/technology.php';

// engine still missing, maybe reduce reactor weight a bit
// Ship parts:
// - bridge/cockpit (pilot, systems) hard to hit
// - body (reactor, systems, weapons, ammunition) easy to hit
// - weapon phalanx (weapons, ammunition) medium to hit
// - engine (engine) medium to hit

// Weapons:
// Add bullet amount per firing
// Add accuracy
// Add damage
// Add ammunition type

// Startup:
// Ragnarok Mk I; reactor (-5), plating (-5), laser (-6)... (7 left)
// Ragnarok Mk I; reactor (-5), plating (-4), laser (-6), 2 blaster (-8)... (0 left)
// Ragnarok Mk I; reactor (-5), plating (-6), 2 laser (-12)... (0 left)
// Ragnarok Mk I; reactor (-5), 3 laser (-18)... (0 left)

// Ragnarok Mk I; reactor (-5), plating (-3), cargo (-8)... (7 left)
// Ragnarok Mk I; reactor (-5), plating (-2), 2 cargo (-16)... (0 left)

// Ragnarok Mk I; reactor (-5), plating (-3), junk (-8)... (7 left)
// Ragnarok Mk I; reactor (-5), plating (-2), junk (-8), cargo (-16)... (0 left)

// Buy a ship automatically sells the old ship and unequips everything.
// Level up clan base by putting money in.
// Creating a clan only possible at a certain minimum level.
// Levels give skill points.

$techIds = array(
	'SMALL_BLASTER_ID'			=> 60,
	'BLASTER_AMMUNITION_ID'		=> 70,
	'NUCLEAR_BATTERIES_ID'		=> 80,
	'COMBUSTION_DRIVE_ID'		=> 90,

	'KINETIC_SHIELD_ID'			=> 120,
	'ENERGY_SHIELD_ID'			=> 121,
	'DISTORTION_SHIELD_ID'		=> 122,

	'SMALL_CAPACITOR_ID'		=> 130,

	'IRON_ID'					=> 1000,
	'PLASTICS_ID'				=> 1025,
	'WATER_ID'					=> 1030,
	'COOLANT_ID'				=> 1035,

	'CRYSTALS_ID'				=> 1050,
	'NOBLE_GAS_ID'				=> 1075,

	'ELECTRONICS_ID'			=> 1100,

	'ENERGY_CELLS_ID'			=> 1150,

	'SPACE_JUNK_ID'				=> 1200,
	'TOXIC_WASTE_ID'			=> 1225,

	'TECHNICAL_COMPONENTS_ID'	=> 1250,
	'COOLER_ID'					=> 1275
);

foreach ($techIds as $name => $techId) {
	define($name, $techId);
}


// Galaxy on Fire items:
// http://forums.fishlabs.net/fishlabs-boards-english-20/galaxy-fire-2-124/galaxy-fire-2-java-127/1237-list-items.html


/*
        <====O
    ________M_M____________
  / /_o/ / <==O   | o |  W |C~~~
/______/___<==O___|___|____|C~~~
Cockpit  Weaponry  Body  Engine

*/

$technology = array();
/*$Technology[-1] = array(
	'type'		=> Technology::TYPE_STOCKAGE,
	'name'		=> 'Stockage',
	'weight'	=> 0,
	'tonnage'	=> 30,
	'slots' => array(
		'stock' => 1
	)
);*/

$technology[-1] = array(
	'type' => null
);	// Stockage

// ID in registration config.
$technology[1] = array(
	'type'		=> Technology::TYPE_STARSHIP,
	'name'		=> 'RagnarokMkI',
	'weight'	=> 30,
	'tonnage'	=> 18,
	'structure'	=> 57,
	'slots' => array(
		'weaponry'		=> 3,
		'ammunition'	=> 2,
		'equipment'		=> 1,
		'cargo'			=> 1,
		'engine'		=> 2
	)
);
// ID in registration config.
$technology[2] = array(
	'type'		=> Technology::TYPE_STARSHIP,
	'name'		=> 'GenesisSC4',
	'weight'	=> 30,
	'tonnage'	=> 21,
	'structure'	=> 33,
	'slots' => array(
		'weaponry'		=> 1,
		'ammunition'	=> 1,
		'equipment'		=> 2,
		'cargo'			=> 3,
		'engine'		=> 2
	)
);

$technology[30] = array(
	'type'		=> Technology::TYPE_MINING_MODULE,
	'name'		=> 'JunkCollector',
	'weight'	=> 8
);

// ballistic, explosion and energy armor
$technology[40] = array(
	'type'		=> Technology::TYPE_PLATING,
	'name'		=> 'ImpactArmor',
	'weight'	=> 1,
	'stack'		=> 1,
	'armor'		=> 9,
	'price'		=> null,	// Value for trading.
	'craft' => array(	// commodities needed to craft it
		IRON_ID	=> 4
	),
	'craftHint'	=> true
);

/*
 * Ideas:
 *
 * Space-Shotgun (LBX)
 * Rapid fire autocannon (AC), Railgun (EMRG = electromagnetic railgun)
 * vulcan gun (too old fashioned?)
 * Missile Pod
 * Imperium Galactica: Anti-matter ray, Torpedo
 * Gauss Cannon (high energy drain)
 *
 * Burst weapons without ammunition:
 * micro-laser, pulse-laser, quad-laser
 */
$technology[SMALL_BLASTER_ID] = array(
	'type'			=> Technology::TYPE_WEAPON,
	'name'			=> 'SmallBlaster',
	'level'			=> 0,
	'weight'		=> 1,
	'damage'		=> 11,
	'reload'		=> 3,
	'drain'			=> 4,
	'burst'			=> 3,
	'damageType'	=> Technology::DAMAGE_KINETIC,
	'ammo'			=> BLASTER_AMMUNITION_ID,
	'price'			=> null,	// Value for trading.
	'craft' => array(
		IRON_ID			=> 2,
		ELECTRONICS_ID	=> 1,
		ENERGY_CELLS_ID	=> 1,
		COOLER_ID		=> 1
	),
	'craftHint'	=> true
);
$technology[61] = array(
	'type'			=> Technology::TYPE_WEAPON,
	'name'			=> 'LightLaser',
	'level'			=> 1,
	'weight'		=> 1,
	'damage'		=> 27,
	'reload'		=> 2,
	'drain'			=> 6,
	'damageType'	=> Technology::DAMAGE_ENERGY,
	'price'			=> null,	// Value for trading.
	'craft' => array(
		IRON_ID			=> 1,
		CRYSTALS_ID		=> 2,
		ENERGY_CELLS_ID	=> 2,
		COOLER_ID		=> 1
	),
	'craftHint'	=> true
);

$technology[BLASTER_AMMUNITION_ID] = array(
	'type'		=> Technology::TYPE_AMMUNITION,
	'name'		=> 'BlasterAmmunition',
	'weight'	=> 1,
	'stack'		=> 150,
	'price'		=> null,	// Value for trading.
	'craft' => array(
		NOBLE_GAS_ID	=> 1,
		ENERGY_CELLS_ID	=> 1
	),
	'craftHint'	=> true
);

/*
 * Energy Shield
 * Kinetic Shield
 * Inertia Shield (distortion shield)
 * Magnetic Shield
 * Gravity Shield
 * Deflector Shield
 * Ultra Shield / Awesome Shield
 * Alien Shield
 * Level 2 Alien Shield
 */
$technology[KINETIC_SHIELD_ID] = array(
	'type'		=> Technology::TYPE_SHIELD,
	'name'		=> 'KineticShield',
	'level'		=> 5,
	'weight'	=> 2,
	'recharge'	=> 1,	// max energy recharge per round
	'buildUp'	=> 10,	// initial energy needed
	'shield'	=> 4,	// "armor" per energy
	'absorb'	=> array(
		Technology::DAMAGE_KINETIC => 2
	),
	'price'		=> 2400	// Value for trading.
);

$technology[ENERGY_SHIELD_ID] = array(
	'type'		=> Technology::TYPE_SHIELD,
	'name'		=> 'EnergyShield',
	'level'		=> 9,
	'weight'	=> 2,
	'recharge'	=> 2,	// max energy recharge per round
	'buildUp'	=> 10,	// initial energy needed
	'shield'	=> 4,	// "armor" per energy
	'absorb'	=> array(
		Technology::DAMAGE_ENERGY => 2
	),
	'price'		=> 7600	// Value for trading.
);

$technology[DISTORTION_SHIELD_ID] = array(
	'type'		=> Technology::TYPE_SHIELD,
	'name'		=> 'DistortionShield',
	'level'		=> 16,
	'weight'	=> 4,
	'recharge'	=> 3,	// max energy recharge per round
	'buildUp'	=> 14,	// initial energy needed
	'shield'	=> 5,	// "armor" per energy
	'absorb'	=> array(
		Technology::DAMAGE_KINETIC => 2,
		Technology::DAMAGE_ENERGY => 2
	),
	'price'		=> 14720	// Value for trading.
);

$technology[NUCLEAR_BATTERIES_ID] = array(
	'type'		=> Technology::TYPE_REACTOR,
	'name'		=> 'NuclearBatteries',
	'level'		=> 0,
	'weight'	=> 3,
	'recharge'	=> 4,
	'capacity'	=> 10,
	'price'		=> 420	// Value for trading.
);

$technology[SMALL_CAPACITOR_ID] = array(
	'type'		=> Technology::TYPE_REACTOR,
	'name'		=> 'SmallCapacitor',
	'level'		=> 1,
	'weight'	=> 1,
	'recharge'	=> 0,
	'capacity'	=> 12,
	'craft' => array(
		TECHNICAL_COMPONENTS_ID => 1,
		ENERGY_CELLS_ID	=> 2
	),
	'craftHint'	=> true
);

$technology[COMBUSTION_DRIVE_ID] = array(
	'type'		=> Technology::TYPE_DRIVE,
	'name'		=> 'CombustionDrive',
	'level'		=> 0,
	'weight'	=> '5',
	'thrust'	=> 2.2,	// Mega Newton (MN)
	'seconds'	=> 7,
	'price'		=> 560	// Value for trading.
);
$technology[91] = array(
	'type'		=> Technology::TYPE_DRIVE,
	'name'		=> 'IonDrive',
	'level'		=> 4,
	'weight'	=> '3',
	'thrust'	=> 3.1,	// Mega Newton (MN)
	'seconds'	=> 7,
	'price'		=> null,	// Value for trading.
	'craft' => array(
		COOLANT_ID				=> 2,
		NOBLE_GAS_ID			=> 5,
		ENERGY_CELLS_ID			=> 3,
		TECHNICAL_COMPONENTS_ID	=> 8,
	),
	'craftHint'	=> true
);
$technology[92] = array(
	'type'		=> Technology::TYPE_DRIVE,
	'name'		=> 'PulseDrive',
	'level'		=> 8,
	'weight'	=> '5',
	'thrust'	=> 5.1,	// == Space Shuttle (3x Hydrogen) Mega Newton (MN)
	'seconds'	=> 8,
	'price'		=> 4640	// Value for trading.
);


/*
 * Crafting basic items:
 * craft:	array of [techId => amount] needed to craft it
 * regain:	array of [techId => chance] to regain item on disassembling
 *
 * Implement regain:
 * Everything that is craftable has a 50% regain chance for 50% of the needed resources (floor)
 */
$technology[IRON_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Iron',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 80,	// Value for trading.
	'craft' => array(
		SPACE_JUNK_ID	=> 1,
		ENERGY_CELLS_ID	=> 1
	),
	'craftHint'	=> true
);
$technology[PLASTICS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Plastics',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 35	// Value for trading.
);
$technology[WATER_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Water',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 5	// Value for trading.
);
$technology[COOLANT_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Coolant',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 75,	// Value for trading.
	'craft' => array(
		WATER_ID		=> 1,
		NOBLE_GAS_ID	=> 1
	),
	'craftHint'	=> true
);
$technology[NOBLE_GAS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'NobleGas',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 55,	// Value for trading.
	'craft' => array(
		ENERGY_CELLS_ID	=> 1,
		TOXIC_WASTE_ID	=> 1
	),
	'craftHint'	=> true
);
$technology[CRYSTALS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Crystals',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 90	// Value for trading.
);
$technology[ELECTRONICS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Electronics',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 120	// Value for trading.
);
$technology[ENERGY_CELLS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'EnergyCells',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 110	// Value for trading.
);

$technology[SPACE_JUNK_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'SpaceJunk',
	'weight'	=> 1,
	'stack'		=> 1,
	'regain' => array(
		IRON_ID			=> array('chance' => 80, 'amount' => 1),
		ELECTRONICS_ID	=> array('chance' => 20, 'amount' => 1)
	)
);
$technology[TOXIC_WASTE_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'ToxicWaste',
	'weight'	=> 1,
	'stack'		=> 1
);
$technology[TECHNICAL_COMPONENTS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'TechnicalComponents',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 220,	// Value for trading.
	'craft' => array(
		IRON_ID			=> 1,
		ELECTRONICS_ID	=> 1
	),
	'regain' => array(
		IRON_ID => array('chance' => 50, 'amount' => 1)
	),
	'craftHint'	=> true
);
$technology[COOLER_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Cooler',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> null,	// Value for trading.
	'craft' => array(
		COOLANT_ID				=> 2,
		TECHNICAL_COMPONENTS_ID	=> 1
	),
	'regain' => array(
		IRON_ID		=> array('chance' => 80, 'amount' => 1),
		COOLANT_ID	=> array('chance' => 40, 'amount' => 2)
	),
	'craftHint'	=> true
);


$basicPrices = array();
foreach ($technology as $techId => &$data) {
	if (isset($data['price'])) {
		$basicPrices[$techId] = $data['price'];
	}
}


do {
	$open = 0;

	foreach ($technology as $techId => &$data) {
		if (!array_key_exists('craft', $data)) {
			continue;
		}

		if (isset($data['price'])) {
			continue;
		}

		$price = 0;

		foreach ($data['craft'] as $ingredientId => $amount) {
			if (!array_key_exists($ingredientId, $basicPrices)) {
				$price = null;
				++$open;

				break;
			}

			$price += $amount * $basicPrices[$ingredientId];
		}

		if ($price) {
			$price = (int)round($price * 1.15);

			$data['price'] = $price;
			$basicPrices[$techId] = $price;
		}

	}
}
while ($open > 0);


$output = array('<?php');
foreach ($techIds as $name => $techId) {
	$output[] = "define('{$name}', {$techId});";
}

$serialized = serialize($technology);
$output[] = "\$technology = unserialize('{$serialized}');";

$output = implode("\n", $output);

file_put_contents('tech_config.php', $output);