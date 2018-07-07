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
    if ($error) {
        return false; 
    } else {
        return $dest; 
    }
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
    if ($error) {
        return false; 
    } else {
        return $dest; 
    }
} 


if (isset($_GET['bzip2'])) {
    gzCompressFile('Packages');
    echo 'bzip2';
}

if (isset($_GET['gzip'])) {
    bzCompressFile('Packages');
    echo 'gzip';
}