<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../db/DB.php';

function getAllTweaks()
{
	$res = DB::select('SELECT * FROM repo_tweaks');
	return $res;
}

function createTweak($tweak_data)
{
	return "
Package: $tweak_data[Package]
Version: $tweak_data[Version]
Architecture: iphoneos-arm
Maintainer: $tweak_data[Maintainer]
Filename: ./debs/$tweak_data[Filename]
Size: $tweak_data[Size]
MD5sum: $tweak_data[MD5sum]
Section: $tweak_data[Section]
Homepage: http://jailgeek.ru
Description: $tweak_data[Description]
Author: $tweak_data[Author]
Name: $tweak_data[Name]

";
}

function gzCompression() { 
	$dest = '../Packages.gz'; 
	$mode = 'wb9';
	$error = false;
	if ($fp_out = gzopen($dest, $mode)) { 
		if ($tweaks_data = getAllTweaks()) { 
			foreach ($tweaks_data as $tweak) {
				gzwrite($fp_out, createTweak($tweak)); 
			}
		} else {
			$error = true; 
		}
		gzclose($fp_out); 
	} else {
		$error = true; 
	}
	if ($error) {
		return false; 
	} else {
		return $dest; 
	}
}

function bzCompression() { 
	$dest = '../Packages.bz2'; 
	$mode = 'w'; 
	$error = false;
	if ($fp_out = bzopen($dest, $mode)) { 
		if ($tweaks_data = getAllTweaks()) { 
			foreach ($tweaks_data as $tweak) {
				gzwrite($fp_out, createTweak($tweak)); 
			}
		} else {
			$error = true; 
		}
		bzclose($fp_out); 
	} else {
		$error = true; 
	}
	if ($error)
		return false; 
	else
		return $dest; 
} 

// gzCompression();
// bzCompression();
// echo 'PACKAGER';