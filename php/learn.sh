cd /e/www/workstudio/
git clone https://github.com/zendframework/zf2
git reset --hard 886063a



git clone https://github.com/sebastianbergmann/phpunit
git reset --hard 5b578d3

git clone https://github.com/composer/composer
composer install
ls -d tests/Composer/Test/* | parallel --gnu --keep-order 'echo "Running {} tests"; ./vendor/bin/phpunit -c tests/complete.phpunit.xml {};'
./vendor/bin/phpunit -c tests/complete.phpunit.xml tests/Composer/Test/Autoload/
