<?php

ob_start();
session_start();
include ('auth.php');
$api = new auth();

if(isset($_POST['MODE']) && $_POST['MODE'] == 'storeVisitor'){
    
}


?>