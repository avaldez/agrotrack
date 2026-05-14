<?php
// Try to fix SSL by getting the CA bundle from PHP's official source
$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);

// Try downloading from alternative sources that might have different CA bundles
$sources = [
    'https://raw.githubusercontent.com/php/php-src/master/win32/build/cacert.pem',
    'https://github.com/curl/curl/raw/master/lib/ca-bundle.crt',
];

foreach ($sources as $url) {
    echo "Trying $url...\n";
    $content = @file_get_contents($url, false, $ctx);
    if ($content && strlen($content) > 100000) {
        file_put_contents('C:/xampp/php/extras/ssl/cacert2.pem', $content);
        echo "  saved " . strlen($content) . " bytes\n";
        
        // Test with curl and this bundle
        $ch = curl_init('https://repo.packagist.org/packages.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, 'C:/xampp/php/extras/ssl/cacert2.pem');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        $err = curl_errno($ch);
        curl_close($ch);
        
        if ($err === 0) {
            echo "  SUCCESS with this bundle!\n";
            copy('C:/xampp/php/extras/ssl/cacert2.pem', 'C:/xampp/php/extras/ssl/cacert.pem');
            break;
        } else {
            echo "  curl errno: $err\n";
        }
    }
}
