<?php

// connect
$ftp = ftp_connect("46.30.40.94");
if (!$ftp) die('could not connect.');

// login
$a = ftp_login($ftp, "vh25774_icaria", "o0rK7Mqs");
if (!$a) die('could not login.');

$path = '.';

ftpRecursiveFileListing($ftp,$path);

function ftpRecursiveFileListing($ftpConnection, $path) { 
    static $allFiles = array(); 
    $contents = ftp_nlist($ftpConnection, $path); 

    foreach($contents as $currentFile) { 
        // assuming its a folder if there's no dot in the name 
        if (strpos($currentFile, '.') === false) { 
            ftpRecursiveFileListing($ftpConnection, $currentFile); 
        } 
        $allFiles[$path][] = substr($currentFile, strlen($path) + 1); 
    } 
    return $allFiles; 
}

?>