#!/bin/sh
SQL_DIR="/var/www/sql/";

for i in ${SQL_DIR}/*
do
	NAME=`echo ${i}|cut -d'/' -f5`;
	echo ${NAME};
	#mysqldump --no-data --extended-insert --complete-insert -u root -pytrezaqw $(1) > ~/documents/sql/$(1)_s.sql;
	#mysqldump --no-create-info -u root -pytrezaqw $(1) > ~/documents/sql/$(1)_d.sql;
done

