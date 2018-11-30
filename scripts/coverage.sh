#!/bin/bash

rm -rf ./target/reports/php-coverage
mkdir -p ./target/reports/php-coverage
src/main/php/vendor/phpunit/phpunit/phpunit --colors -c ./src/test/php/coverage.xml --bootstrap ./src/test/localbootstrap.php $1
