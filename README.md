# Doctrine Performance Optimization

These are the examples used in my [conference talk](https://speakerdeck.com/afilina/doctrine-performance-optimization).

Create a database to match this configuration:

```php
$dbParams = [
    'driver' => 'pdo_mysql',
    'dbname' => 'doctrine_perf',
    'user' => 'root',
    'password' => '',
];
```

`./setup.sh` to install the dependencies and prepare the database.

`./run-all.sh` to execute all of the benchmarks.

`php ./benchmarks/[filename]` to run individual benchmarks. 
