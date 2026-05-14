<?php
/*
 * Composer SSL Bypass Wrapper
 * Usage: php composer-bypass.php install
 * 
 * This wrapper forces Composer to use HTTP instead of HTTPS
 * for all connections by modifying the stream context.
 */

// Create a stream context that skips SSL verification
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
    'http' => [
        'follow_location' => true,
        'max_redirects' => 5,
    ],
]);

// Register the context as default
stream_context_set_default([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

// Set environment variables that composer might use
putenv('COMPOSER_CAFILE=NUL');  // Windows null device
putenv('CURL_CA_BUNDLE=NUL');

// Find composer
$composerPaths = [
    'C:/Users/USUARIO/.config/herd-lite/bin/composer.phar',
    'C:/devtools/composer/composer.phar',
];

$composerPhar = null;
foreach ($composerPaths as $path) {
    if (file_exists($path)) {
        $composerPhar = $path;
        break;
    }
}

if (!$composerPhar) {
    die("Composer phar not found!\n");
}

// Build command
$args = array_slice($argv, 1);
$argsStr = implode(' ', array_map('escapeshellarg', $args));

$cmd = sprintf(
    '"C:\\xampp\\php\\php.exe" -d curl.cainfo=NUL -d openssl.cafile=NUL -f %s %s',
    $composerPhar,
    $argsStr
);

echo "Running: $cmd\n\n";
passthru($cmd, $exitCode);
exit($exitCode);
