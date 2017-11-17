<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$entityManager = require_once 'bootstrap.php';
return ConsoleRunner::createHelperSet($entityManager);