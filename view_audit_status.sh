#!/bin/bash
step=1 #间隔的秒数，不能大于60
for (( i = 0; i < 60; i=(i+step) )); do
    $(php /home/deployer/platform/app/console appcoachs_material:send_material_status)
    sleep $step
done
exit 0