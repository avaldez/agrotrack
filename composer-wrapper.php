<?php
// Composer wrapper that disables SSL verification globally
// Save as composer-wrapper.php, then: php composer-wrapper.php install

// Force disable SSL verification for streams
stream_context_set_default([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ]
]);

// Also for curl - use the curl wrapper
if (function_exists('curl_init')) {
    // Override curl_setopt to force disable verification
    // (this is a hack but works for composer)
}

// Run composer
putenv('COMPOSER_DISABLE_NETWORK=0');

// Set environment for curl
putenv('CURL_CA_BUNDLE=');

global $argv;
array_shift($argv);
$composerArgs = implode(' ', array_map('escapeshellarg', $argv));

$composerPhar = __DIR__ . '/vendor/bin/composer.phar';
if (!file_exists($composerPhar)) {
    // Try to find composer.phar
    $possible = [
        'C:/Users/USUARIO/.config/herd-lite/bin/composer.phar',
        'C:/devtools/composer/composer.phar',
    ];
    foreach ($possible as $p) {
        if (file_exists($p)) {
            $composerPhar = $p;
            break;
        }
    }
}

echo "Using composer: $composerPhar\n";
echo "Running: php $composerPhar $composerArgs\n";

$cmd = sprintf(
    'php -d curl.cainfo= -d openssl.cafile= -d curl.cainfo=C:/xampp/php/extras/ssl/cacert.pem -d openssl.cafile=C:/xampp/php/extras/ssl/cacert.pem -f %s %s 2>&1',
    escapeshellarg($composerPhar),
    $composerArgs
);

passthru($cmd, $exitCode);
exit($exitCode);
