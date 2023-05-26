<?php

ob_start();
session_start();
include ('auth.php');
$api = new auth();

if(isset($_POST['MODE']) && $_POST['MODE'] == 'contact'){
    $name = $api->filter_data($_POST['name']);
    $email = $api->filter_data($_POST['email']);
    $msg = $api->filter_data($_POST['message']);
    echo "{'name': '$name', 'email': '$email', 'msg': '$msg'}";
}


?>