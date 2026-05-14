<?php
$dir = __DIR__ . '/public/icons';
if (!is_dir($dir)) mkdir($dir, 0755, true);

$sizes = [72, 96, 128, 144, 152, 192, 384, 512];
$green = [29, 158, 117];

foreach ($sizes as $s) {
    $img = imagecreatetruecolor($s, $s);
    $bg = imagecolorallocate($img, $green[0], $green[1], $green[2]);
    imagefill($img, 0, 0, $bg);
    imagepng($img, "$dir/icon-{$s}.png");
    imagedestroy($img);
    echo "icon-{$s}.png ";
}
echo "\nDone";
