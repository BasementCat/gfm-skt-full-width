#!/usr/bin/env bash
cd /tmp

export DEBIAN_FRONTEND=noninteractive
apt-get update
apt-get install -y apache2 mysql-server php5 php-pear php5-mysql php5-common libapache2-mod-php5 php5-cli php5-gd

# Configure MySQL
mysqladmin -u root password 'password'
echo "create database wordpress;" |mysql -uroot -ppassword
cat >/etc/mysql/conf.d/55-network.cnf <<EOT
[mysqld]
bind-address = 0.0.0.0
EOT

service mysql restart
service apache2 restart

# Get wordpress files installed
rm -rf /var/www
wget http://wordpress.org/latest.tar.gz
tar -xvvzf latest.tar.gz
mv wordpress /var/www
rm latest.tar.gz

# Setup...
cat >/var/www/wp-config.php <<EOT
<?php
define('DB_NAME', 'wordpress');
define('DB_USER', 'root');
define('DB_PASSWORD', 'password');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

EOT

wget -qO - https://api.wordpress.org/secret-key/1.1/salt/ >>/var/www/wp-config.php

cat >>/var/www/wp-config.php <<EOT
\$table_prefix  = 'wp_';
define('WP_DEBUG', false);
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');
EOT

ln -s /vagrant/skt-full-width /var/www/wp-content/themes/
