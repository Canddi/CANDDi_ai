#!/bin/bash

src/main/php/vendor/phpunit/phpunit/phpunit --stderr --verbose --colors --bootstrap ./src/test/localbootstrap.php  $1

