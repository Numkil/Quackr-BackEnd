--Drop older versions of scheme
DROP SCHEMA IF EXISTS quackr_r0428905 CASCADE;

--Creating new database from scratch
CREATE SCHEMA quackr_r0428905;

--Default scheme is this one
set SEARCH_PATH TO quackr_r0428905;

--Schema rights
GRANT ALL ON SCHEMA quackr_r0428905 TO r0428905;
GRANT ALL ON SCHEMA quackr_r0428905 TO r0428453;

--Automatic creation for id's
CREATE SEQUENCE questions_id_seq;
CREATE SEQUENCE categories_id_seq;

--Sequence rights
GRANT ALL ON SEQUENCE questions_id_seq TO r0428905;
GRANT ALL ON SEQUENCE questions_id_seq TO r0428453;

GRANT ALL ON SEQUENCE categories_id_seq TO r0428905;
GRANT ALL ON SEQUENCE categories_id_seq TO r0428453;

--CATEGORIES
CREATE TABLE categories (
    id INTEGER NOT NULL default nextval('categories_id_seq'),
    categoryname CHARACTER VARYING(45) NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

--QUESTIONS
CREATE TABLE questions (
    id INTEGER NOT NULL default nextval('questions_id_seq'),
    question CHARACTER VARYING(100) NOT NULL,
    lvl INTEGER NOT NULL,
    categoryid INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

--ANSWERS
CREATE TABLE answers (
    questionlink INTEGER NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
    propanswer CHARACTER VARYING(100) NOT NULL,
    correct BOOLEAN NOT NULL
);

--Provide rights on sequences to tables
ALTER SEQUENCE categories_id_seq owned by categories.id;
ALTER SEQUENCE questions_id_seq owned by questions.id;

--Rights on tables for users
GRANT ALL ON TABLE categories TO r0428905;
GRANT ALL ON TABLE categories TO r0428453;
GRANT ALL ON TABLE questions TO r0428905;
GRANT ALL ON TABLE questions TO r0428453;
GRANT ALL ON TABLE answers TO r0428905;
GRANT ALL ON TABLE answers TO r0428453;
