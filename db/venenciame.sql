------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS countries CASCADE;

CREATE TABLE countries
(
    id          BIGSERIAL       PRIMARY KEY
  , code        VARCHAR(2)      NOT NULL
  , label       VARCHAR(64)     NOT NULL
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS states CASCADE;

CREATE TABLE states
(
    id          BIGSERIAL       PRIMARY KEY
  , label       VARCHAR(64)     NOT NULL
  , country_id  BIGINT          REFERENCES countries (id)   
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS languages CASCADE;

CREATE TABLE languages
(
    id          BIGSERIAL       PRIMARY KEY
  , code        VARCHAR(2)      NOT NULL UNIQUE
  , label       VARCHAR(64)     NOT NULL UNIQUE
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
    id          BIGSERIAL    PRIMARY KEY
  , label       VARCHAR(64)  NOT NULL UNIQUE
  , updated_at  TIMESTAMP(0)
  , created_at  TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS status CASCADE;

CREATE TABLE status
(
    id          BIGSERIAL       PRIMARY KEY
  , label       VARCHAR(64)     NOT NULL UNIQUE
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users
(
    id              BIGSERIAL     PRIMARY KEY
  , username        VARCHAR(32)   NOT NULL        UNIQUE
  , password        VARCHAR(64)   NOT NULL
  , email           VARCHAR(64)   NOT NULL        UNIQUE
  , auth_key        VARCHAR(32)   DEFAULT NULL
  , verf_key        VARCHAR(32)   DEFAULT NULL
  , status_id       BIGINT        REFERENCES status (id)
  , admin           BOOLEAN       DEFAULT FALSE
  , privacity       BOOLEAN       DEFAULT FALSE
  , name            VARCHAR(32)
  , surname         VARCHAR(32)
  , birthdate       DATE
  , image           VARCHAR(255)
  , rol_id          BIGINT        REFERENCES roles (id)
  , language_id     BIGINT        REFERENCES languages (id)
  , updated_at      TIMESTAMP(0)
  , created_at      TIMESTAMP(0)  DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS partners CASCADE;

CREATE TABLE partners
(
    id            BIGSERIAL     PRIMARY KEY
  , user_id       BIGINT        UNIQUE      NOT NULL  REFERENCES users (id)
  , name          VARCHAR(32)   UNIQUE      NOT NULL
  , description   VARCHAR(255)
  , information   TEXT
  , image         VARCHAR(255)
  , image_id      VARCHAR(255)
  , country_id    BIGINT        NOT NULL    REFERENCES countries (id)
  , state_id      BIGINT        NOT NULL    REFERENCES states (id)
  , status_id     BIGINT                    REFERENCES status (id)
  , city          VARCHAR(64)   NOT NULL
  , zip_code      VARCHAR(64)   NOT NULL
  , address       VARCHAR(64)   NOT NULL
  , phone         VARCHAR(64)   NOT NULL
  , url           VARCHAR(64)
  , email         VARCHAR(64)
  , updated_at    TIMESTAMP(0)
  , created_at    TIMESTAMP(0)  NOT NULL    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS followers CASCADE;

CREATE TABLE followers
(
    id            BIGSERIAL     PRIMARY KEY
  , user_id       BIGINT        NOT NULL  REFERENCES users (id)
  , partner_id    BIGINT        NOT NULL  REFERENCES partners (id)
  , created_at    TIMESTAMP(0)  DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS categories CASCADE;

CREATE TABLE categories
(
    id          BIGSERIAL       PRIMARY KEY
  , label       VARCHAR(64)     NOT NULL UNIQUE
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS denominations CASCADE;

CREATE TABLE denominations
(
    id          BIGSERIAL       PRIMARY KEY
  , label       VARCHAR(64)     NOT NULL UNIQUE
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS vats CASCADE;

CREATE TABLE vats
(
    id          BIGSERIAL       PRIMARY KEY
  , label       VARCHAR(64)     NOT NULL UNIQUE
  , value       INTEGER         NOT NULL UNIQUE
  , created_at  TIMESTAMP(0)    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS articles CASCADE;

CREATE TABLE articles
(
    id                  BIGSERIAL     PRIMARY KEY
  , partner_id          BIGINT        NOT NULL    REFERENCES partners      (id)   ON DELETE CASCADE ON UPDATE CASCADE
  , category_id         BIGINT        NOT NULL    REFERENCES categories    (id)   ON DELETE CASCADE ON UPDATE CASCADE
  , denomination_id     BIGINT        NOT NULL    REFERENCES denominations (id)   ON DELETE CASCADE ON UPDATE CASCADE
  , vat_id              BIGINT        NOT NULL    REFERENCES vats          (id)   ON DELETE CASCADE ON UPDATE CASCADE
  , status_id           BIGINT        DEFAULT 2   REFERENCES status        (id)   ON DELETE CASCADE ON UPDATE CASCADE
  , name_id             VARCHAR(50)   UNIQUE      NOT NULL
  , title               VARCHAR(50)   NOT NULL
  , description         VARCHAR(255)  NOT NULL
  , price               DECIMAL       NOT NULL
  , stock               INTEGER       NOT NULL
  , degrees             VARCHAR(255)  NOT NULL
  , capacity            INTEGER       NOT NULL
  , variety             VARCHAR(255)  NOT NULL
  , pairing             VARCHAR(255)  NOT NULL
  , review              TEXT          NOT NULL
  , image               VARCHAR(255)  DEFAULT NULL
  , created_at          TIMESTAMP(0)  DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS favorites CASCADE;

CREATE TABLE favorites
(
    id            BIGSERIAL     PRIMARY KEY
  , user_id       BIGINT        NOT NULL  REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
  , article_id    BIGINT        NOT NULL  REFERENCES articles (id) ON DELETE CASCADE ON UPDATE CASCADE
  , created_at    TIMESTAMP(0)  DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS reviews CASCADE;

CREATE TABLE reviews
(
    id            BIGSERIAL     PRIMARY KEY
  , user_id       BIGINT        NOT NULL  REFERENCES users (id)     ON DELETE CASCADE ON UPDATE CASCADE
  , article_id    BIGINT        NOT NULL  REFERENCES articles (id)  ON DELETE CASCADE ON UPDATE CASCADE
  , review        TEXT          NOT NULL
  , score         INTEGER       NOT NULL  CONSTRAINT ck_value_min_max CHECK (score >= 0 AND score <=5)
  , created_at    TIMESTAMP(0)  DEFAULT CURRENT_TIMESTAMP
  , UNIQUE (user_id, article_id)
);

DROP TABLE IF EXISTS cart_items CASCADE;

CREATE TABLE cart_items
(
    id            BIGSERIAL     PRIMARY KEY
  , user_id       BIGINT        NOT NULL  REFERENCES users (id)   
  , article_id    BIGINT        NOT NULL  REFERENCES articles (id)
  , status_id     BIGINT                  REFERENCES status (id)
  , quantity      INTEGER       NOT NULL
  , created_at    TIMESTAMP(0)  DEFAULT CURRENT_TIMESTAMP
);