#!/bin/bash

# This script removes all user-created MySQL databases

# MySQL credentials
user="root"
password="root"

# Confirmation prompt
read -p "Are you sure you want to remove all user-created MySQL databases? This action cannot be undone. [y/n] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    exit 1
fi

# Get a list of all user-created databases
databases=`mysql --user=$user --password=$password -e "SHOW DATABASES;" | tr -d "| " | grep -v Database | grep -v mysql| grep -v sys | grep -v information_schema | grep -v performance_schema`

# Drop all user-created databases
for db in $databases; do
    echo "Removing database: $db"
    mysql --user=$user --password=$password -e "DROP DATABASE $db"
done

echo "All user-created MySQL databases have been removed successfully!"

# Connect to MySQL as root
mysql --user=root --password=$password -e "

# Get a list of all users except root
SELECT User FROM mysql.user WHERE User NOT IN ('mysql.infoschema', 'mysql.session','mysql.sys','root');

# Prepare to delete each user
" | while read -r user; do

# Delete the user
mysql --user=root --password=$password -e "DROP USER '$user'@'%';"
echo "Deleting user: $user"

done
echo "All users removed successfully!"
