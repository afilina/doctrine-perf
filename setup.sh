echo "==================="
echo "composer install"
echo "==================="
composer install

echo "==================="
echo "seed database"
echo "==================="
php ./benchmarks/seed.php
