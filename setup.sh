set -e
service mysql start
mysql < /mysql/setup.sql
service mysql stop