<?php
// Alternative: export the certificate using Windows cert store via PHP COM
try {
    $store = new COM("CAPICOM.Store");
    $store->Open(1, "Root", 1); // CAPICOM_CURRENT_USER_STORE = 2, CAPICOM_LOCAL_MACHINE_STORE = 1

    echo "Store opened\n";
    
    foreach ($store->Certificates as $cert) {
        $subject = $cert->SubjectName;
        if (strpos($subject, 'Avast') !== false) {
            echo "Found: $subject\n";
            $pem = $cert->Export(2); // CAPICOM_ENCODE_BASE64 = 1, CAPICOM_ENCODE_BINARY = 2... actually CAPICOM_ENCODE_ANY = 0
            // Actually Export doesn't take encoding type on CAPICOM
            // Let's try a different approach
        }
    }
} catch (Exception $e) {
    echo "COM Error: " . $e->getMessage() . "\n";
    echo "Trying alternative...\n";
    
    // Use PowerShell to export
    $psScript = @'
$cert = Get-ChildItem -Path Cert:\LocalMachine\Root | Where-Object { $_.Subject -like "*Avast*" } | Select-Object -First 1
if ($cert) {
    $cert | Export-Certificate -FilePath C:\tmp\agrotrack\avast-root.cer -Type CERT
    Write-Output "Exported: $($cert.Subject)"
} else {
    Write-Output "Not found in LocalMachine"
}
$cert2 = Get-ChildItem -Path Cert:\CurrentUser\Root | Where-Object { $_.Subject -like "*Avast*" } | Select-Object -First 1
if ($cert2) {
    $cert2 | Export-Certificate -FilePath C:\tmp\agrotrack\avast-root2.cer -Type CERT
    Write-Output "Exported from CurrentUser: $($cert2.Subject)"
} else {
    Write-Output "Not found in CurrentUser"
}
'@;
    file_put_contents('C:/tmp/agrotrack/export_avast.ps1', $psScript);
    exec('powershell -ExecutionPolicy Bypass -File C:/tmp/agrotrack/export_avast.ps1 2>&1', $psOut, $psRet);
    echo implode("\n", $psOut) . "\n";
    echo "PS ret: $psRet\n";
}
