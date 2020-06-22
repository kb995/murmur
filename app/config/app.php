<?php

// 設定
// ==============================
ini_set('display_errors', 1);
session_start();

// DBデータ取得
// ==============================
// DB設定
const DSN = 'mysql:host=localhost;dbname=murmur;charset=utf8';
const USERNAME = 'root';
const PASSWORD = 'root';

// DB接続
function dbConnect() {
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
    return $dbh;
}