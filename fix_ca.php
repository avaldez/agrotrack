<?php
// Try to get CA bundle from multiple sources
$urls = [
    'https://curl.se/ca/cacert.pem',
    'https://github.com/bagder/ca-bundle/raw/master/ca-bundle.crt',
];

$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);

foreach ($urls as $url) {
    echo "Trying: $url\n";
    $content = @file_get_contents($url, false, $ctx);
    if ($content && strlen($content) > 50000) {
        file_put_contents('C:/xampp/php/extras/ssl/cacert.pem', $content);
        echo "Saved " . strlen($content) . " bytes\n";

        // Test with curl
        $ch = curl_init('https://repo.packagist.org/packages.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, 'C:/xampp/php/extras/ssl/cacert.pem');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($errno === 0) {
            echo "CURL OK: " . strlen($result) . " bytes\n";
            return;
        } else {
            echo "CURL errno: $errno  - continuing...\n";
        }
    }
}

echo "All sources failed!\n";
