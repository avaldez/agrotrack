<?php
// Convert extracted PFX to PEM and add to cacert.pem
$pfx = file_get_contents('C:/tmp/agrotrack/avast-root.p12');

if (openssl_pkcs12_read($pfx, $certs, '')) {
    echo "PFX read with empty password\n";
} elseif (openssl_pkcs12_read($pfx, $certs, '1234')) {
    echo "PFX read with '1234' password\n";
} else {
    echo "Failed to read PFX: " . openssl_error_string() . "\n";
    exit(1);
}

if (openssl_x509_export($certs['cert'], $pem)) {
    file_put_contents('C:/tmp/agrotrack/avast-root.pem', $pem);
    echo "Avast root PEM saved: " . strlen($pem) . " bytes\n";
    echo $pem . "\n";

    // Now append to cacert.pem
    $currentBundle = file_get_contents('C:/xampp/php/extras/ssl/cacert.pem');
    $newBundle = $currentBundle . "\n\n" . $pem;
    file_put_contents('C:/xampp/php/extras/ssl/cacert.pem', $newBundle);
    echo "cacert.pem updated: " . strlen($newBundle) . " bytes\n";

    // Test
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
} else {
    echo "Failed to export PEM: " . openssl_error_string() . "\n";
}
