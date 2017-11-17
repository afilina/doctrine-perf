<?php
$entityManager = require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/shared-config.php';

use DoctrinePerformance as Model;

logMemory();

$batchSize = 200;
$userIterations = ceil($numUsers / $batchSize);
$user = new Model\User();

logMemory();

for ($i=0; $i < $userIterations; $i++)
{
    $users = $entityManager
        ->getRepository(Model\User::class)
        ->createQueryBuilder('user')
        ->select('user.id')
        ->setFirstResult($i * $batchSize)
        ->setMaxResults($batchSize)
        ->getQuery()
        ->getResult();

    $userIds = array_map(function($value) {
        return $value['id'];
    }, $users);

    logMemory();
    unset($users);
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
    
    unset($values);
    logMemory();
}

require __DIR__ . '/shared-output.php';
