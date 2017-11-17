<?php
$entityManager = require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/shared-config.php';

use DoctrinePerformance as Model;

logMemory();

$users = $entityManager
    ->getRepository(Model\User::class)
    ->createQueryBuilder('user')
    ->select('user')
    ->getQuery()
    ->getResult();

logMemory();

$billing = [];
foreach ($users as $user) {
    if ($user->billingAddress) {
        $billing[$user->id] = $user->billingAddress->address;
    }
}

logMemory();

require __DIR__ . '/shared-output.php';
