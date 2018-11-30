#!/bin/bash

export APPLICATION_ENV="development"
export APPLICATION_PATH="/Volumes/SourceCode/CANDDi/canddi/src/main/php"
export VENDOR_PATH="/Volumes/SourceCode/CANDDi/canddi/src/main/php/vendor/"
export APPLICATION_CONFIG_PATH="/Volumes/SourceCode/CANDDi/canddi/src/main/php/Canddi/Helper/Config/config/canddi"

PHPCOMMAND=`which php`
${PHPCOMMAND} ${APPLICATION_PATH}/cli/cli.php "$@"
