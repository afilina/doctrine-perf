<?php
$entityManager = require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/shared-config.php';

use DoctrinePerformance as Model;

logMemory();

$users = $entityManager
    ->getRepository(Model\User::class)
    ->createQueryBuilder('user')
    ->select('user')
    ->setMaxResults($numUsers)
    ->getQuery()
    ->getResult();

logMemory();

foreach ($users as $i => $user)
{
    foreach ($propertyNames as $property)
    {
        $value = $entityManager
            ->getRepository(Model\CustomProperty::class)
            ->createQueryBuilder('property')
            ->select('property')
            ->where('property.name = :property_name')
            ->andWhere('property.user = :user_id')
            ->setParameter('property_name', $property)
            ->setParameter('user_id', $user->id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if ($i == 0) {
            logMemory();
        }
    }
}

require __DIR__ . '/shared-output.php';
