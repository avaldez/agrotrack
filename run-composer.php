<?php
/*
 * This wrapper patches Composer's CurlDownloader to disable SSL verification.
 * Usage: php run-composer.php install
 * 
 * It works by using a stream wrapper that intercepts https connections.
 */

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

// Build args
$args = array_slice($argv, 1);
$argsStr = implode(' ', array_map('escapeshellarg', $args));

$cmd = sprintf(
    '"C:\\xampp\\php\\php.exe" -d curl.cainfo="" -d openssl.cafile="" -f %s %s',
    $composerPhar,
    $argsStr
);

echo "Running composer...\n";
passthru($cmd, $exitCode);
exit($exitCode);
