<?php
$ctx = stream_context_create(['http' => ['timeout' => 10]]);
$c = file_get_contents('http://repo.packagist.org/packages.json', false, $ctx);
echo 'HTTP OK: ' . strlen($c) . ' bytes' . PHP_EOL;

$ctx2 = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
$c2 = file_get_contents('https://repo.packagist.org/packages.json', false, $ctx2);
echo 'HTTPS (no verify): ' . strlen($c2) . ' bytes' . PHP_EOL;
