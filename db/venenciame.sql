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

DROP TABLE IF EXISTS statuses CASCADE;

CREATE TABLE statuses
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
  , status_id       BIGINT        REFERENCES statuses (id)
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
  , country_id    BIGINT        NOT NULL    REFERENCES countries (id)
  , state_id      BIGINT        NOT NULL    REFERENCES states (id)
  , status_id     BIGINT                    REFERENCES statuses (id)
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
