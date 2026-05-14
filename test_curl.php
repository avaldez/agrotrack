<?php
$ch = curl_init('https://repo.packagist.org/packages.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CAINFO, 'C:/xampp/php/extras/ssl/cacert.pem');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$errno = curl_errno($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "errno: $errno\n";
echo "error: $error\n";
echo "http_code: " . ($info['http_code'] ?? 'N/A') . "\n";
echo "size: " . strlen($result ?? '') . "\n";
