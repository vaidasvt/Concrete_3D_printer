#!/usr/bin/php
<?php

$file = $argv[1];
$svg = file_get_contents($file);

// trim precission
$svg = preg_replace('/(\.[0-9]{4})[0-9]*/', '$1', $svg);
//var_dump($svg);


// invert sweap-flag on arcs
//A 1.665 1.665 0 0 1
$svg = preg_replace_callback('/(A [0-9\.]* [0-9\.]* [0-9\.]* [0-9\.]* )([0-9\.]*)/', 'fix_sweap', $svg);
//var_dump($svg);


//echo $svg;
$ext = pathinfo($file,PATHINFO_EXTENSION);
$out_file = preg_replace("/\.{$ext}$/s",'_fixed.'.$ext, $file);
file_put_contents($out_file,$svg);;


function fix_sweap($m) {
	$sweap = ($m[2])?'0':'1';
	return $m[1].$sweap;
}

