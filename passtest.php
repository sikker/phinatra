<?php

function one (&$foo) {
	$foo .= ' one ';
	var_dump($foo);
	two($foo);
}

function two (&$foo) {
	$foo .= ' two ';
	var_dump($foo);
	three($foo);
}

function three (&$foo) {
	$foo .= ' three ';
	var_dump($foo);
}

$foo = 'Luksus';

one($foo);

var_dump($foo);
