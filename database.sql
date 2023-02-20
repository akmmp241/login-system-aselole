CREATE DATABASE login_system_aselole;

USE login_system_aselole;

CREATE TABLE users (
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE InnoDB;

CREATE TABLE sessions
(
    id      VARCHAR(255) NOT NULL PRIMARY KEY,
    user_username VARCHAR(255) NOT NULL,
    CONSTRAINT fk_sessions_user
        FOREIGN KEY (user_username) REFERENCES
            users (username)
)ENGINE InnoDB;

ALTER TABLE users DROP COLUMN email;
