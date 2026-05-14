<?php
// Convert DER binary to PEM and add to bundle
$der = file_get_contents('C:/tmp/agrotrack/avast-root.cer');

// Create PEM from DER
$pem = "-----BEGIN CERTIFICATE-----\n";
$pem .= chunk_split(base64_encode($der), 64, "\n");
$pem .= "-----END CERTIFICATE-----\n";

echo "Avast Root CA PEM:\n";
echo $pem . "\n";

// Validate by reading it back
$cert = openssl_x509_read($pem);
if ($cert === false) {
    echo "ERROR: Created PEM is not valid: " . openssl_error_string() . "\n";
    exit(1);
}
echo "PEM validated successfully\n";

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
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "CURL test: errno=$errno http_code=$httpCode\n";
if ($errno === 0) {
    echo "SUCCESS: " . strlen($result) . " bytes\n";
} else {
    echo "FAILED: $error\n";
}
