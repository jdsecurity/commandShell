!#/bin/bash

curl -sS https://getcomposer.org/installer | php
php -r "readfile('https://getcomposer.org/installer');" | php
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin

# Mac OS X
brew update
brew tap josegonzalez/homebrew-php
brew tap homebrew/versions
brew install php55-intl
bres install josegonzalez/php/composer

#windows
echo @php "%~dp0composer.phar" %*>composer.bat

#composer.json
{
  "require": {
    "monolog/monolog": "1.2.*"
  }
}

composer install #php composer.phar install

#php
require 'vendor/autoload.php';

composer update point/lib
# composer record the md5sum of composer.json
composer update nothing
composer update --lock

composer require "point/lib:1.0.0"
composer init --require=point/lib:1.0.0 -n

composer install --profile --prefer-source
composer install --profile --prefer-dist
composer status -v
composer update
