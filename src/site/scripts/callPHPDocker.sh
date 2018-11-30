#!/bin/bash

PHPCOMMAND=`which php`
${PHPCOMMAND} ${APPLICATION_PATH}/cli/cli.php "$@"
