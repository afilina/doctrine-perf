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

$userIds = array_map(function($value) {
    return $value->id;
}, $users);

logMemory();

foreach ($propertyNames as $property)
{
    $values = $entityManager
        ->getRepository(Model\CustomProperty::class)
        ->createQueryBuilder('property')
        ->select('property')
        ->where('property.name = :property_name')
        ->andWhere('property.user IN (:user_ids)')
        ->setParameter('property_name', $property)
        ->setParameter('user_ids', $userIds)
        ->getQuery()
        ->getResult();

    logMemory();
}

require __DIR__ . '/shared-output.php';
