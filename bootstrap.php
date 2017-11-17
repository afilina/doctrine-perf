<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/benchmarks/profiling.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Proxy\ProxyFactory;

AnnotationRegistry::registerLoader('class_exists');

$config = new Configuration();
$config->setMetadataDriverImpl(new AnnotationDriver(new AnnotationReader(), [__DIR__.'/models']));
$config->setProxyDir(sys_get_temp_dir() . '/doctrine-perf' . uniqid());
$config->setProxyNamespace('ProxyExample');
$config->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_EVAL);

$sqlLogger = new \Doctrine\DBAL\Logging\DebugStack();
$sqlLogger->enabled;
$config->setSQLLogger($sqlLogger);

$dbParams = [
    'driver' => 'pdo_mysql',
    'dbname' => 'doctrine_perf',
    'user' => 'root',
    'password' => '',
];
$entityManager = EntityManager::create($dbParams, $config);
return $entityManager;
