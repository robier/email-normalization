<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Robier\EmailNormalization\Canonicalizer;
use Robier\EmailNormalization\Provider;

$canonicalizer = new Canonicalizer(
    null,
    new Provider\Apple(),
    new Provider\Fastmail(),
    new Provider\Google(),
    new Provider\Hey(),
    new Provider\Microsoft(),
    new Provider\ProtonMail(),
    new Provider\Rackspace(),
    new Provider\Rambler(),
    new Provider\Yahoo(),
    new Provider\Yandex(),
    new Provider\Zoho(),
    new Provider\NullMail(),
);

$handle = fopen(__DIR__ . '/fake-emails', 'r');

$start = microtime(true);

while(($email = fgets($handle)) !== false) {
    echo $canonicalizer->canonize($email) . "\n";
}

echo "\n" . (microtime(true) - $start);
