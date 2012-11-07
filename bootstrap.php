<?php

spl_autoload_register(function($class) {
	$space = explode('\\', strtolower($class));
	$first = array_shift($space);
	if ($first !== 'phinatra') {
		return;
	}
	$path = __DIR__;
	foreach ($space as $name) {
		$path = $path . '/' . $name;
	}
	require $path . '.php';
});


