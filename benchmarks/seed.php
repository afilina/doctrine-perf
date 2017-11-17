<?php
$entityManager = require __DIR__ . '/../bootstrap.php';

use Doctrine\ORM\Tools\SchemaTool;
use DoctrinePerformance as Model;

$schemaTool = new SchemaTool($entityManager);
$metadata   = $entityManager->getMetadataFactory()->getAllMetadata();
$schemaTool->dropSchema($metadata);
$schemaTool->createSchema($metadata);

$faker = Faker\Factory::create();
// Pregenerate reusable objects with fake data
// since it's costly and we don't need unique data each time, just enough variety.
$propertySet = createPropertySet($faker);
$addressSet = createAddressSet($faker, 50);
$salesRepSet = createUserSet($faker, 10);

for ($i=0; $i<2000; $i++)
{ 
    $user = new Model\User();
    $user->firstName = $faker->firstName();
    $user->lastName = $faker->lastName();
    $user->email = $faker->email();

    $user->billingAddress = clone $addressSet[array_rand($addressSet)];
    $user->shippingAddress = clone $addressSet[array_rand($addressSet)];
    $user->salesRep = $salesRepSet[array_rand($salesRepSet)];

    for ($j=0; $j < 5; $j++) { 
        $property = clone $propertySet[$j];
        $property->user = $user;
        $user->customProperties[] = $property;
    }

    $entityManager->persist($user);

    // Save in batches to reduce number of queries.
    if ($i % 25 == 0) {
        $entityManager->flush();
    }
}
$entityManager->flush();

function createPropertySet($faker)
{
    foreach (['company', 'originalSource', 'jobTitle', 'dateOfBirth', 'points'] as $name) {
        $property = new Model\CustomProperty();
        $property->name = $name;
        $property->value = $faker->text(50);
        $set[] = $property;
    }
    return $set;
}

function createAddressSet($faker, $length)
{
    $set = [];
    for ($i=0; $i < $length; $i++) { 
        $address = new Model\Address();
        $address->address = $faker->address();
        $address->city = $faker->city();
        $address->country = $faker->country();
        $set[] = $address;
    }
    return $set;
}

function createUserSet($faker, $length)
{
    $set = [];
    for ($i=0; $i < $length; $i++) { 
        $user = new Model\User();
        $user->firstName = $faker->firstName();
        $user->lastName = $faker->lastName();
        $user->email = $faker->email();
        $set[] = $user;
    }
    return $set;
}
