<?php

require_once '../db/DB.php';

function createTweakData($tweak) {
    $name = $tweak['name'];
    $bundle_id = $tweak['bundle_id'];
    $description = $tweak['description'];
    $version = $tweak['version'];
    $author = $tweak['author'];
    $section = $tweak['section'];
    return "
Name: $name
Package: $bundle_id
Version: $version
Architecture: iphoneos-arm
Maintainer: $author
Filename: debs/package.deb
Section: $section
Homepage: HOMEPAGE
Description: $description
Author: $author


";
}

function getAllTweaks() {
	$tweaks = DB::select("
		SELECT
			rt.name,
			rt.bundle_id,
			rt.description,
			rt.version,
			rt.author,
			rs.name as section
		FROM repo_tweaks rt
		left join repo_sections rs on section=rs.id;");
	return $tweaks;
}

// print_r(getAllTweaks());

class packages
{
	public function refresh()
	{
		$this->refreshBZ();
		$this->refreshGZ();
		return 'Refresh success!';
	}

	public function refreshAll()
	{
		return 'All refresh success!';
	}


	public function refreshBZ()
	{
		$dest = '../repofiles/Packages.bz2'; 
		$mode = 'w'; 
		$error = false;
		$tweaks = getAllTweaks();
		if ($fp_out = bzopen($dest, $mode)) { 
			foreach ($tweaks as $key => $tweak) {
				bzwrite($fp_out, createTweakData($tweak)); 
			}
			bzclose($fp_out); 
		} else {
			$error = true; 
		}
		
		if ($error) {
			return false; 
		}
		return 'BZip2 refresh success!';
	}

	public function refreshGZ()
	{
		$dest = '../repofiles/Packages.gz'; 
		$mode = 'wb9';
		$error = false;
		$tweaks = getAllTweaks();
		if ($fp_out = gzopen($dest, $mode)) { 
			foreach ($tweaks as $key => $tweak) {
				gzwrite($fp_out, createTweakData($tweak));
			}
			gzclose($fp_out); 
		} else {
			$error = true; 
		}
		if ($error) {
			return false; 
		}
		return 'Gzip refresh success!';
	}

}