<?php
require_once('../config/app.php');

if($_SESSION['login_flg']) {
    session_destroy();
    $_SESSION = array();
    header('Location: ../login.php');
  }
