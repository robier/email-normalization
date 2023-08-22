<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$filePath = __DIR__ . '/fake-emails';

$count = (int)($argv[1] ?? 1000000);

if (is_file($filePath)) {
    unlink($filePath);
}
$handle = fopen($filePath, 'w');

$providers = [
    new \Robier\EmailNormalization\Provider\Apple(),
    new \Robier\EmailNormalization\Provider\Fastmail(),
    new \Robier\EmailNormalization\Provider\Google(),
    new \Robier\EmailNormalization\Provider\Hey(),
    new \Robier\EmailNormalization\Provider\Microsoft(),
    new \Robier\EmailNormalization\Provider\ProtonMail(),
    new \Robier\EmailNormalization\Provider\Rackspace(),
    new \Robier\EmailNormalization\Provider\Rambler(),
    new \Robier\EmailNormalization\Provider\Yahoo(),
    new \Robier\EmailNormalization\Provider\Yandex(),
    new \Robier\EmailNormalization\Provider\Zoho(),
];

$domains = [];
foreach ($providers as $provider) {
    $domains = array_merge($domains, $provider->domains());
}

function randomString(int $count): string
{
    $characters = 'abcdefgh.ijklmnopq-r_stuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $count; $i++) {
        $randstring .= $characters[rand(0, strlen($characters) - 1)];
    }
    return trim($randstring, '.-_');
}

$i = 0;
while (true) {
    $i++;

    $email = randomString(rand(5, 15)) . '@' . ($domains[array_rand($domains)]) . "\n";

    fwrite($handle, $email);

    if ($i === $count) {
        break;
    }
}

echo "DONE!\n";
