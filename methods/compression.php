<?php
include_once 'db/DB.php';

function gzCompressFile($source, $level = 9){ 
    $dest = $source . '.gz'; 
    $mode = 'wb' . $level; 
    $error = false; 
    if ($fp_out = gzopen($dest, $mode)) { 
        if ($fp_in = fopen($source,'rb')) { 
            while (!feof($fp_in)) 
                gzwrite($fp_out, fread($fp_in, 1024 * 512)); 
            fclose($fp_in); 
        } else {
            $error = true; 
        }
        gzclose($fp_out); 
    } else {
        $error = true; 
    }
    if ($error)
        return false; 
    else
        return $dest; 
} 

function bzCompressFile($source){ 
    $dest = $source . '.bz2'; 
    $mode = 'w'; 
    $error = false;
    if ($fp_out = bzopen($dest, $mode)) { 
        if ($fp_in = fopen($source,'rb')) { 
            while (!feof($fp_in)) 
                bzwrite($fp_out, fread($fp_in, 1024 * 512)); 
            fclose($fp_in); 
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


function getAllTweaks() {
    $tweaks = DB::select('SELECT * from repo_tweaks;');
    // echo json_encode($tweaks);
    return $tweaks;
}

function createTweakData($tweak) {
    $name = $tweak['name'];
    $bundle_id = $tweak['bundle_id'];
    $description = $tweak['description'];
    $version = $tweak['version'];
    return "
Name: $name
Package: $bundle_id
Version: $version
Architecture: iphoneos-arm
Maintainer: MAINTAINER
Filename: ./debs/Package.deb
Section: Themes
Homepage: HOMEPAGE
Description: $description
Author: AUTHOR


";
}

// getAllTweaks();

function bzCompressTweaks($source){ 
    $dest = $source . '.bz2'; 
    $mode = 'w'; 
    $error = false;
    $tweaks = getAllTweaks();
    if ($fp_out = bzopen($dest, $mode)) { 
        if ($fp_in = fopen($source,'rb')) { 
            foreach ($tweaks as $key => $tweak) {
                bzwrite($fp_out, createTweakData($tweak)); 
            }
            fclose($fp_in); 
        } else {
            $error = true; 
        }
        bzclose($fp_out); 
    } else {
        $error = true; 
    }
    
    if ($error) {
        return false; 
    }
    else {
        return $dest; 
    }
}

function gzCompressTweaks($source, $level = 9){ 
    $dest = $source . '.gz'; 
    $mode = 'wb' . $level; 
    $error = false; 
    $tweaks = getAllTweaks();
    if ($fp_out = gzopen($dest, $mode)) { 
        if ($fp_in = fopen($source,'rb')) { 
            foreach ($tweaks as $key => $tweak) {
                gzwrite($fp_out, createTweakData($tweak));
            }
            fclose($fp_in); 
        } else {
            $error = true; 
        }
        gzclose($fp_out); 
    } else {
        $error = true; 
    }
    if ($error)
        return false; 
    else
        return $dest; 
}