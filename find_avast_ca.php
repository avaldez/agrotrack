<?php
// The certificate shows it's signed by Avast Web/Mail Shield Root
// Let's extract the root certificate from the stream and add it to the bundle

$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);

// Get the current bundle
$currentBundle = file_get_contents('C:/xampp/php/extras/ssl/cacert.pem', false, $ctx);

// The Avast root cert is the issuer. Let's extract the server cert from the connection
// and use it along with the root (which we'll need to get from Avast)

// First, get the certificate from the server using openssl
$serverCert = null;

$ch = curl_init('https://repo.packagist.org/packages.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_CERTINFO, true);
curl_exec($ch);
$certInfo = curl_getinfo($ch, CURLINFO_CERTINFO);
curl_close($ch);

// Extract the certificate PEM
$serverPEM = '';
if (isset($certInfo[0]['Cert'])) {
    $serverPEM = $certInfo[0]['Cert'];
}

// Look for Avast certificates in Windows cert store
$avastCerts = [];
$output = [];
exec('certutil -store Root 2>&1', $output, $ret);
$current = '';
foreach ($output as $line) {
    if (preg_match('/Avast|Web\/Mail Shield|AVAST/i', $line)) {
        $avastCerts[] = $line;
    }
}

echo "Avast certificates found in Windows store:\n";
print_r($avastCerts);

// Try to export Avast certificates
$output2 = [];
exec('certutil -store Root "Avast Web/Mail Shield Root" 2>&1', $output2, $ret);
echo "\nCertutil output:\n";
echo implode("\n", $output2) . "\n";

// Search for any certificate files
$searchPaths = [
    'C:/ProgramData/AVAST Software/Avast',
    'C:/Program Files/AVAST Software/Avast',
    'C:/Program Files (x86)/AVAST Software/Avast',
];

foreach ($searchPaths as $path) {
    if (is_dir($path)) {
        echo "\nSearching $path for cert files...\n";
        $files = glob("$path/**/*.pem") + glob("$path/**/*.crt") + glob("$path/*.pem") + glob("$path/*.crt");
        foreach ($files as $f) {
            echo "  Found: $f\n";
        }
    }
}
