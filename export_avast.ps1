$cert = Get-ChildItem -Path Cert:\LocalMachine\Root | Where-Object { $_.Subject -like "*Avast*" } | Select-Object -First 1
if ($cert) {
    Export-Certificate -FilePath "C:\tmp\agrotrack\avast-root.cer" -Type CERT -Cert $cert
    Write-Output "Exported from LocalMachine: $($cert.Subject)"
} else {
    Write-Output "Not found in LocalMachine"
}
$cert2 = Get-ChildItem -Path Cert:\CurrentUser\Root | Where-Object { $_.Subject -like "*Avast*" } | Select-Object -First 1
if ($cert2) {
    Export-Certificate -FilePath "C:\tmp\agrotrack\avast-root.cer" -Type CERT -Cert $cert2
    Write-Output "Exported from CurrentUser: $($cert2.Subject)"
} else {
    Write-Output "Not found in CurrentUser"
}
