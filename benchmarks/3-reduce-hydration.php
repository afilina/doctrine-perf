<?php
$entityManager = require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/shared-config.php';

use DoctrinePerformance as Model;

logMemory();

$users = $entityManager
    ->getRepository(Model\User::class)
    ->createQueryBuilder('user')
    ->select('user.id')
    ->setMaxResults($numUsers)
    ->getQuery()
    ->getResult();

$userIds = array_map(function($value) {
    return $value['id'];
}, $users);

logMemory();

$user = new Model\User();

logMemory();

foreach ($propertyNames as $property)
{
    $values = $entityManager
        ->getRepository(Model\CustomProperty::class)
        ->createQueryBuilder('property')
        ->select('property.id, property.value')
        ->where('property.name = :property_name')
        ->andWhere('property.user IN (:user_ids)')
        ->setParameter('property_name', $property)
        ->setParameter('user_ids', $userIds)
        ->getQuery()
        ->getResult();

    if ($property == 'email') {
        foreach ($values as $value) {
            $user->email = $value['email'];
            $mailToTag = $user->getMailToTag();
        }
    }

    logMemory();
}

require __DIR__ . '/shared-output.php';
