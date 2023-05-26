<?php
session_start();

$_SESSION['isLoggedIn'] = false;
unset($_SESSION['uid']);

session_unset();
session_destroy();

header("Location: /");

exit;