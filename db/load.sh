#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/venenciame.sql
fi
psql -h localhost -U venenciame -d venenciame_test < $BASE_DIR/venenciame.sql
