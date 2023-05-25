<?php
session_start();

$_SESSION['isLoggedIn'] = false;
unset($_SESSION['role']);
unset($_SESSION['uid']);
unset($_SESSION['bid']);

session_unset();
session_destroy();

header("Location: /");

exit;