<?php
// Try downloading from alternate sources with different CA bundles
$urls = [
    'https://github.com/curl/curl/raw/master/lib/ca-bundle.crt',
    'https://raw.githubusercontent.com/bagder/ca-bundle/main/ca-bundle.crt',
];

$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);

$downloaded = false;
foreach ($urls as $url) {
    echo "Trying: $url\n";
    $content = @file_get_contents($url, false, $ctx);
    if ($content && strlen($content) > 50000 && !$downloaded) {
        file_put_contents('C:/xampp/php/extras/ssl/cacert.pem', $content);
        echo "Saved " . strlen($content) . " bytes\n";
        $downloaded = true;
    }
}

// Now let's check what CA signed repo.packagist.org
echo "\nChecking repo.packagist.org certificate:\n";
$ch = curl_init('https://repo.packagist.org');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CAINFO, 'C:/xampp/php/extras/ssl/cacert.pem');
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_STDERR, fopen('php://temp', 'w+'));
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$errno = curl_errno($ch);
$err = curl_error($ch);

echo "CURL error: $errno - $err\n";

// Get verbose info
$info = curl_getinfo($ch);
print_r($info);
curl_close($ch);

if ($errno === 0) {
    echo "\nSUCCESS!\n";
} else {
    echo "\nFAILED with error $errno\n";
    echo "Trying to get certificate info via openssl...\n";
    exec('openssl s_client -connect repo.packagist.org:443 -showcerts 2>&1', $output, $ret);
    echo implode("\n", array_slice($output, 0, 50)) . "\n";
}
