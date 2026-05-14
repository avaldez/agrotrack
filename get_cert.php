<?php
// Get the SSL certificate from repo.packagist.org and create a CA bundle
$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);

// Download the current cacert from a reliable source
$cacert = file_get_contents('https://curl.se/ca/cacert.pem', false, $ctx);

// Also try to get the certificate chain directly
$url = 'https://repo.packagist.org';
$host = parse_url($url, PHP_URL_HOST);

echo "Getting certificate chain for $host...\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_CERTINFO, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_exec($ch);
$info = curl_getinfo($ch);

// Try to extract cert info
$certInfo = curl_getinfo($ch, CURLINFO_CERTINFO);

curl_close($ch);

echo "HTTP Code: " . ($info['http_code'] ?? 'N/A') . "\n";

if (isset($certInfo) && is_array($certInfo)) {
    echo "Certificate info available:\n";
    print_r($certInfo);
    
    // Append any found certificates to the bundle
    $cacert .= "\n\n" . implode("\n\n", $certInfo);
}

// Save
file_put_contents('C:/xampp/php/extras/ssl/cacert.pem', $cacert);
echo "Saved: " . strlen($cacert) . " bytes\n";

// Test
$ch2 = curl_init('https://repo.packagist.org/packages.json');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_CAINFO, 'C:/xampp/php/extras/ssl/cacert.pem');
curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
$r = curl_exec($ch2);
$e = curl_errno($ch2);
curl_close($ch2);

echo "Test with new bundle: errno=$e\n";
if ($e === 0) {
    echo "SUCCESS!\n";
} else {
    echo "Still failing. errno=$e\n";
    echo "curl error: " . curl_error($ch2) . "\n";
}
