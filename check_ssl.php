<?php
/**
 * Manual package installer using PHP streams (bypasses curl SSL issue)
 * Run: php install-packages.php
 */

// First, let's check the real PHP stream issue
echo "PHP Version: " . PHP_VERSION . "\n";
echo "curl.cainfo: " . (ini_get('curl.cainfo') ?: 'NOT SET') . "\n\n";

echo "Testing stream_context_create with ssl...\n";
$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
$test = @file_get_contents('https://repo.packagist.org/packages.json', false, $ctx);
if ($test) {
    echo "Streams OK: " . strlen($test) . " bytes\n\n";
}

echo "Testing CURL with custom CAINFO...\n";
$ch = curl_init('https://repo.packagist.org/packages.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$result = curl_exec($ch);
$errno = curl_errno($ch);
$error = curl_error($ch);
curl_close($ch);

if ($errno === 0) {
    echo "CURL OK (with verify disabled): " . strlen($result) . " bytes\n";
} else {
    echo "CURL FAILED: errno=$errno error=$error\n";
}
