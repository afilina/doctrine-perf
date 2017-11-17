<?php
use DeepCopy\Filter\Doctrine\DoctrineProxyFilter;
use DeepCopy\Filter\Doctrine\DoctrineCollectionFilter;
use DeepCopy\Matcher\Doctrine\DoctrineProxyMatcher;
use DeepCopy\Matcher\PropertyTypeMatcher;

$memoryLog = [];
$startTime = 0;

function logMemory()
{
    global $memoryLog;
    $backtrace = debug_backtrace();
    $line = $backtrace[0]['line'];

    $memoryLog[] = [
        'usage' => memory_get_usage(false), 
        'line' => $line
    ];
}

function outputSqlLog()
{
    global $sqlLogger;

    $numQueries = count($sqlLogger->queries);

    echo "Num queries: {$numQueries}\n";
}

function outputTimeLog()
{
    global $startTime, $sqlLogger;

    $queryTime = 0;
    foreach ($sqlLogger->queries as $query) {
        $queryTime += $query['executionMS'];
    }
    $scriptTime = round(microtime(true) - $startTime - $queryTime, 4);
    $queryTime = round($queryTime, 4);

    echo "Query time: {$queryTime}s\n";
    echo "Other time: {$scriptTime}s\n";
}

function outputMemoryLog()
{
    global $memoryLog;

    $outputLogs = [];
    $groupByLines = [];

    foreach ($memoryLog as $log) {
        $groupByLines[$log['line']][] = $log;
    }

    // You can change the logic here to, for example, output all logs instead of highest per line.
    foreach ($groupByLines as $lineLogs) {
        $highestLog = getHighestLog($lineLogs);
        $outputLogs[] = $highestLog;
    }

    foreach ($outputLogs as $i => $log) {
        $change = $i == 0 ? 0 : $log['usage'] - $outputLogs[$i - 1]['usage'];
        $redableUsage = readableBytes($log['usage']);
        $readableChange = readableBytes($change);
        $change = $change > 0 ? "+{$readableChange}" : "{$readableChange}";
        echo "Memory used: {$redableUsage} ({$change}) line:{$log['line']}\n";
    }

    $highestLog = getHighestLog($outputLogs);
    $redableUsage = readableBytes($highestLog['usage']);
    echo "Peak memory used: {$redableUsage} line:{$highestLog['line']}\n";
    
    $loggerClone = null;
}

function getHighestLog($logs)
{
    return array_reduce($logs, function($carry, $item) {
        if ($item['usage'] > $carry['usage']) {
            $carry = $item;
        }
        return $carry;
    });
}

function readableBytes($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

$startTime = microtime(true);
