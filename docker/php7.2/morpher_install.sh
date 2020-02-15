#!/bin/bash
DEBIAN_FRONTEND=noninteractive
apt-get update -y -q
apt-get install gcc make autoconf libc-dev pkg-config build-essential

cd /home
git clone https://jon73ul:06460646Jon@gitlab.com/jon73ul/morpher.git
chmod -R 777 morpher
cd morpher/php/
./build.sh
php_modules=$(php-config --extension-dir)
cd modules/
cp morpher.so $php_modules
cat > /usr/local/etc/php/conf.d/morpher.ini << EOF
; configuration for php morpher module
; priority=20
extension=morpher.so
EOF
# ln -s /etc/php/7.2/mods-available/morpher.ini /etc/php/7.2/fpm/conf.d/morpher.ini
# ln -s /etc/php/7.2/mods-available/morpher.ini /etc/php/7.2/cli/conf.d/morpher.ini
# phpenmod morpher
