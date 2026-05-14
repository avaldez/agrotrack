<?php
// Convert DER .cer to PEM and append to cacert.pem
$der = file_get_contents('C:/tmp/agrotrack/avast-root.cer');

// The file might be DER or may already be base64. Check
if (strpos($der, '-----BEGIN') !== false) {
    echo "Already PEM format\n";
    $pem = $der;
} else {
    // It's DER binary, convert to PEM
    $cert = openssl_x509_read($der);
    if ($cert === false) {
        echo "Failed to read DER certificate\n";
        exit(1);
    }
    openssl_x509_export($cert, $pem);
    echo "Converted DER to PEM: " . strlen($pem) . " bytes\n";
}

echo "PEM content:\n";
echo $pem . "\n";

// Append to cacert.pem
$currentBundle = file_get_contents('C:/xampp/php/extras/ssl/cacert.pem');
$newBundle = $currentBundle . "\n" . $pem;
file_put_contents('C:/xampp/php/extras/ssl/cacert.pem', $newBundle);
echo "cacert.pem updated: " . strlen($newBundle) . " bytes\n";

// Test with curl
$ch = curl_init('https://repo.packagist.org/packages.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CAINFO, 'C:/xampp/php/extras/ssl/cacert.pem');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$errno = curl_errno($ch);
$error = curl_error($ch);
curl_close($ch);

if ($errno === 0) {
    echo "CURL TEST SUCCESS: " . strlen($result) . " bytes\n";
} else {
    echo "CURL TEST FAILED: errno=$errno error=$error\n";
}
