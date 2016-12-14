#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PROJECTFOLDER='QMVC'


# git pull QMVC
if [ -d "/var/www/html/${PROJECTFOLDER}" ] 
then
    (exec "./bootstrap.sh") 
else
    cd "/var/www/html/${PROJECTFOLDER}"
    sudo git pull
fi
