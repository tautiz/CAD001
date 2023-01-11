#!/bin/bash

# This script creates a backup of all MySQL databases

# Get the current date
date=$(date +%F)

# MySQL credentials
user="root"
password="root"

# Backup destination
dest="/tmp"

# Create backup file name
file_name="mysql-backup-$date.sql"

# Dump all MySQL databases
mysqldump --user=$user --password=$password --all-databases > $dest/$file_name

echo "MySQL backup created successfully. File Name: $file_name"