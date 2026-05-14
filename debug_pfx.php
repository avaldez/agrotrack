<?php
$pfx = file_get_contents('C:/tmp/agrotrack/avast-root.p12');

if (openssl_pkcs12_read($pfx, $certs, '')) {
    echo "Keys in certs array:\n";
    print_r(array_keys($certs));
    
    foreach ($certs as $key => $val) {
        if (is_string($val) && strlen($val) < 200) {
            echo "$key: $val\n";
        } elseif (is_object($val) && $val instanceof \OpenSSLCertificate) {
            echo "$key: OpenSSLCertificate\n";
            openssl_x509_export($val, $pem);
            echo $pem . "\n";
            file_put_contents('C:/tmp/agrotrack/avast-root.pem', $pem);
        } elseif (is_object($val)) {
            echo "$key: " . get_class($val) . "\n";
        } else {
            echo "$key: " . gettype($val) . " (" . (is_string($val) ? strlen($val) . ' bytes' : '') . ")\n";
        }
    }
}

// Also try openssl_pkcs12_read without results and try the cert from the array
echo "\n\nTrying alternate export...\n";

if (isset($certs['cert'])) {
    echo "cert found\n";
} else {
    // Try iterating
    foreach ($certs as $k => $v) {
        echo "Checking $k...\n";
        if (is_object($v)) {
            $toPem = openssl_x509_export($v, $out);
            echo "Export result: " . ($toPem ? 'OK' : 'FAIL') . "\n";
            if ($toPem) {
                file_put_contents('C:/tmp/agrotrack/avast-root.pem', $out);
                echo "Saved!\n";
            } else {
                echo "Error: " . openssl_error_string() . "\n";
            }
        }
    }
}
