<?php
$opts = [
    'http' => ['method' => 'GET', 'follow_location' => true],
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
];
$ctx = stream_context_create($opts);
$content = file_get_contents('https://curl.se/ca/cacert.pem', false, $ctx);
file_put_contents('C:/xampp/php/extras/ssl/cacert.pem', $content);
echo "OK: " . strlen($content) . " bytes\n";
