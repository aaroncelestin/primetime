<?php
const DB_DSN = "mysql:dbname=auth;host=localhost";
const DB_NAME = 'users';
const DB_USER = 'user';
const DB_PASSWORD = '';
const DB_CHARSET = 'charset=UTF8';
const DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_CASE => PDO::CASE_NATURAL,
    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];