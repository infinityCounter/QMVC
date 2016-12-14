#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PROJECTFOLDER='QMVC'


# git pull QMVC
if [ is_dir  "/var/www/html/${PROJECTFOLDER}"]; then
    ("./bootstrap.sh")
fi
    cd "/var/www/html/${PROJECTFOLDER}"
    sudo git pull
