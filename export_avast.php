<?php
// Export Avast Root CA from Windows certificate store and add to cacert.pem

// Export the Avast root certificate to a file
$exportCmd = 'certutil -exportpfx -p "" Root "Avast Web/Mail Shield Root" C:/tmp/agrotrack/avast-root.pfx 2>&1';
exec($exportCmd, $output, $ret);
echo "PFX export: ret=$ret\n";

// Try exporting as BASE64 encoded CER
$exportCmd2 = 'certutil -encode Root "Avast Web/Mail Shield Root" C:/tmp/agrotrack/avast-root.cer 2>&1';
exec($exportCmd2, $output2, $ret2);
echo "CER export: ret=$ret2\n";
echo implode("\n", $output2) . "\n";

// Try another format
$exportCmd3 = 'certutil -exportpfx Root "Avast Web/Mail Shield Root" C:/tmp/agrotrack/avast-root.p12 2>&1';
exec($exportCmd3, $output3, $ret3);
echo "P12 export: ret=$ret3\n";

// Check what was created
$files = glob('C:/tmp/agrotrack/avast-root.*');
echo "Created files:\n";
foreach ($files as $f) {
    echo "  $f - " . filesize($f) . " bytes\n";
    if (pathinfo($f, PATHINFO_EXTENSION) === 'cer') {
        $content = file_get_contents($f);
        echo "  Content:\n$content\n";
    }
}
