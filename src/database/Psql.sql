-- Att 23/03/2021

CREATE DATABASE base_php;

\c base_php

CREATE TABLE users (
    id SERIAL, 
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);