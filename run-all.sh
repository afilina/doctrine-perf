echo "==================="
echo "1-no-optimizations"
echo "==================="
php ./benchmarks/1-no-optimizations.php

echo "==================="
echo "2-group-by-column"
echo "==================="
php ./benchmarks/2-group-by-column.php

echo "==================="
echo "3-reduce-hydration"
echo "==================="
php ./benchmarks/3-reduce-hydration.php

echo "==================="
echo "4-unset-results"
echo "==================="
php ./benchmarks/4-unset-results.php

echo "==================="
echo "5-split-to-batches"
echo "==================="
php ./benchmarks/5-split-to-batches.php

echo "==================="
echo "6-lazy-loading-example"
echo "==================="
php ./benchmarks/6-lazy-loading-example.php

echo "==================="
echo "7-join-example"
echo "==================="
php ./benchmarks/7-join-example.php
