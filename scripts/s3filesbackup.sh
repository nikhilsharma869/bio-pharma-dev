#!/bin/bash

# Basic variables
bucket="s3://bio-pharma-files-backup"
stamp=`date +"%s - %A %d %B %Y @ %H%M"`
filename="bio-pharma.zip"
object="$bucket/$stamp/$filename"

# Zip
echo -e "\e[1;32mZipping files.\e[00m"
zip -r /var/www/backup-s3/biopharma.zip /var/www/html/

# Upload
echo -e "\e[1;32mUploading file on S3.\e[00m"
s3cmd --config /root/.s3cfg put /var/www/backup-s3/biopharma.zip "$object"

# Delete
echo -e "\e[1;32mDeleting file on server.\e[00m"
rm -rf /var/www/backup-s3/biopharma.zip

# Completed
echo -e "\e[1;32mTask Complete!\e[00m"