#!/bin/sh
set -e

GREEN="\033[0;32m"
BLUE="\033[1;34m"
RED="\033[0;31m"
NC="\033[0m"

START=$PWD

HASMECAB=$(php -r 'echo extension_loaded("mecab");')

OUTPUT=$(php --version) 

LONGVERSION=$(echo $OUTPUT | cut -d ' ' -f2 | cut -d '-' -f1)

SHORTVERSION=${LONGVERSION%.*}

echo $SHORTVERSION

echo "${GREEN}Installing dependencies...${NC}"
apt-get install -y mecab mecab-ipadic-utf8 mecab-utils libmecab-dev unzip wget

if [ $HASMECAB ] ; then
    echo "${BLUE}php-mecab is already installed.${NC}"

elif [ -d /usr/local/etc/php/conf.d ] ; then
    echo "${GREEN}Installing php-mecab...${NC}"
    wget https://github.com/nihongodera/php-mecab/archive/master.zip
    unzip master.zip
    cd php-mecab-master/mecab && phpize && ./configure --with-php-config=/usr/local/bin/php-config --with-mecab-config=/usr/local/bin/mecab-config && make && make install
    cd /usr/local/etc/php/conf.d
    touch mecab.ini
    echo "extension=mecab.so" | tee -a mecab.ini

    echo "${BLUE}Cleaning up...${NC}"

    cd $START
    rm master.zip
    rm -rf "php-mecab-master"

else
    echo "${RED}Unable to install php-mecab.${NC}"
    exit 1

fi
echo "${GREEN}Install complete.${NC}"
