#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PROJECTFOLDER='QMVC'

cd "/var/www/html/${PROJECTFOLDER}"
sudo git pull
