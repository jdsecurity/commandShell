#! phpunit install

required
1. PHP: 5.3.3+
2. dom and json: This is open by default
3. pcre, reflection, spl: This is needed through php core since PHP 5.3.0
4. Xdebug(2.1.3), tokenizer: Code cover report need this extensions.
5. xmlwriter: Create XML report need this extension.


PHAR
1. PHPUnit is publish through the PHAR, The PHPUnit PHAR include all comment of PHPUnit.
2. PHAR extension is open by default in PHP.
3. openssl extension, need this extension if useing the --self-update.
4. open Suhosin: Add the config info "suhosin.executor.include.whitelist = phar" in php.ini file.


install
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/phpunit
phpunit --version

wget https://phar.phpunit.de/phpunit.phar
php phpunit.phar --version

wget https://phar.phpunit.de/phpunit.phar.asc
gpg phpunit.phar.asc
gpg --keyserver pgp.uni-mainz.de --recv-keys 0xAA394086372C20A

install-composer
composer.json
{
  "require-dev": {
    "phpunit/phpunit": "4.3.*",
    "phpunit/php-invoker": "*",
    "phpunit/dbunit": ">=1.2",
    "phpunit/phpunit-selenium": ">=1.2"
  }
}

composer global require "phpunit/phpunit=4.3.*"
