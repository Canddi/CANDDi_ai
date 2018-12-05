#!/bin/bash

vendor/phpunit/phpunit/phpunit --stderr --verbose --colors --bootstrap ./test/localbootstrap.php  $1

