#!/bin/bash

set -ex
export CALL_PHP_PATH="/Volumes/SourceCode/CANDDi/canddi/liveScripts/callPHP.sh"

${CALL_PHP_PATH} -a actionbrowserpush.notifybrowserpush &
${CALL_PHP_PATH} -a actioncallback.callback &
${CALL_PHP_PATH} -a actioncrm.get &
${CALL_PHP_PATH} -a actioncrm.set &
${CALL_PHP_PATH} -a actionhipchat.notifyhipchat &
${CALL_PHP_PATH} -a actionzapier.zapier &
${CALL_PHP_PATH} -a actioncrm.sfwebtolead &
${CALL_PHP_PATH} -a cdnifyclear.trigger &
${CALL_PHP_PATH} -a checkstream.process &
${CALL_PHP_PATH} -a contacts.listen &
${CALL_PHP_PATH} -a expire.listen &
${CALL_PHP_PATH} -a export.listen &
${CALL_PHP_PATH} -a problem.papertrailproblem &
${CALL_PHP_PATH} -a reprocess.alltrackergoals &
${CALL_PHP_PATH} -a reprocess.contact &
${CALL_PHP_PATH} -a reprocess.identifier &
${CALL_PHP_PATH} -a reprocess.stream &
${CALL_PHP_PATH} -a reprocess.trackergoalone &
${CALL_PHP_PATH} -a stream.process &
${CALL_PHP_PATH} -a trigger.listen &
${CALL_PHP_PATH} -a trigger.schedule &
${CALL_PHP_PATH} -a website.emailopen &
${CALL_PHP_PATH} -a website.emailstats &
${CALL_PHP_PATH} -a website.heartbeat &
${CALL_PHP_PATH} -a website.updatesession &

${CALL_PHP_PATH} -a schedule.expire.run &
${CALL_PHP_PATH} -a schedule.messages.processcache &
${CALL_PHP_PATH} -a schedule.triggeraction.summary &

fnBeforeClose()
{
    echo 'Cleaning up spawned child processes'
    # Close the cli.php instances
    ps -ax | grep cli\\.php | while read line; do
        intPId=$(echo $line | awk '{split($0, a, " "); print a[1]}')
        echo "Killing $intPId"
        kill -9 "$intPId" || echo "Child process $i not running"
    done
}

trap fnBeforeClose SIGINT

wait
