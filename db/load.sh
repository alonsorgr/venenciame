#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/venenciame.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/countries-states.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/languages.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/roles.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/statuses.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/users.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/categories.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/denominations.sql
    psql -h localhost -U venenciame -d venenciame < $BASE_DIR/vats.sql
    #psql -h localhost -U venenciame -d venenciame < $BASE_DIR/data.sql
fi
psql -h localhost -U venenciame -d venenciame_test < $BASE_DIR/venenciame.sql
