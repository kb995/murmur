<?php

// * ---------- 設定 ---------- *

// エラーをブラウザに表示
ini_set('display_errors', 1);

// セッション使用
session_start();


// * ---------- DB ---------- *

// DB設定
const DSN = 'mysql:host=localhost;dbname=murmur;charset=utf8';
const USERNAME = 'root';
const PASSWORD = 'root';

// DB接続
function dbConnect() {
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
    return $dbh;
}

// * ---------- その他関数 ---------- *

// サニタイズ
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
