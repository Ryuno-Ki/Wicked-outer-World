<?php

/*
 * Contains all code needed to start up the project.
 */

$baseDir = __DIR__;

require_once $baseDir . '/source/i18n.php';
require_once $baseDir . '/source/configs/base_config.php';
require_once $baseDir . '/source/configs/tech_config.php';
require_once $baseDir . '/source/configs/space_config.php';


$route = array_key_exists('page', $_REQUEST) ? $_REQUEST['page'] : '';
$routes = require_once 'source/configs/route_config.php';
if (!array_key_exists($route, $routes)) {
	$route = 'default';
	$parts = array();
}

require_once $baseDir . '/ext/valkyrie/valkyrie/Autoloader.php';

$autoloader = Valkyrie_Autoloader::create();
$autoloader
	->setScriptGroup($route)
	->setBuildPath($baseDir . '/source/build')
	->addSourcePath($baseDir . '/source/lib')
	->addSourcePath($baseDir . '/ext/lisbeth')
	->addSourcePath($baseDir . '/ext/leviathan')
	->lowerCasePaths()
	->start(VALKYRIE_BUILD);

Config::getInstance()->routes($routes);