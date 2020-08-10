#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE venenciame_test;"
    psql -U postgres -c "CREATE USER venenciame PASSWORD 'venenciame' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists venenciame
    sudo -u postgres dropdb --if-exists venenciame_test
    sudo -u postgres dropuser --if-exists venenciame
    sudo -u postgres psql -c "CREATE USER venenciame PASSWORD 'venenciame' SUPERUSER;"
    sudo -u postgres createdb -O venenciame venenciame
    sudo -u postgres psql -d venenciame -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O venenciame venenciame_test
    sudo -u postgres psql -d venenciame_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:venenciame:venenciame"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
