#!/bin/sh

#################################################################
#  Define your variables here:
#################################################################

FILESTOKEEP=7 BACKUP_DIR=/var/www/html/medicalink-app/backups 
BMYSQL_USER=zerab BMYSQL_PWD=medsur#zerab

DATE=$(date +"%m-%d-%Y")_$(date +"%T")

BMYSQL_HOST=ericVPStaging
BMYSQL_DBNAME=stagingmedicalink
BMYSQL_DBFILENAME=MYSQL_BACKUP_STAGING_MEDICALINK_APP__$DATE


#################################################################
#  Make sure output directory exists.
#################################################################

        if [ ! -d $BACKUP_DIR ]; then
            mkdir -p $BACKUP_DIR
        fi


#################################################################
#  Create backup
#################################################################

        mysqldump -u$BMYSQL_USER -p$BMYSQL_PWD $BMYSQL_DBNAME  > $BACKUP_DIR/$BMYSQL_DBFILENAME.sql 

#################################################################
#  Remove old backups 
#  - this will list files according to date (DESC)
#  - skip the first few files (FILESTOKEEP)
#  - remove all files past that
#  NOTE: Make sure not to save the backups into any directory
#  where there are other files other than these backup ones.
#
#  Uncomment when you are confident in rest of setup
#################################################################

#      cd $BACKUP_DIR
#      ls -t1 | tail -n +$(($FILESTOKEEP+1)) | xargs rm
