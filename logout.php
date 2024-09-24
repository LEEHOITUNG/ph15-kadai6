<?php

require_once __DIR__ . '/functions/user.php';

session_start();

// セッションに保存してあるIDを削除
unset($_SESSION['id']);

// cookieを削除
setcookie('id', '', time() - 1, '/');

header('Location: ./login.php');

?>

