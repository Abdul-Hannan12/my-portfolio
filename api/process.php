<?php

ob_start();
session_start();
include ('auth.php');
$api = new auth();

if(isset($_POST['MODE']) && $_POST['MODE'] == 'contact'){
    $name = $api->filter_data($_POST['name']);
    $email = $api->filter_data($_POST['email']);
    $msg = $api->filter_data($_POST['message']);
    
    /*
    $to = 'abdulhannan8540680@gmail.com';
    $subject = "Website Contact!";
    $message = "This is a test email message.";

    $headers = "From: '$email'\r\n";
    $headers .= "Reply-To: '$email'\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $mailSent = mail($to, $subject, $message, $headers);

    if ($mailSent) {
        echo "Email sent successfully.";
    } else {
        echo "Failed to send email.";
    }
    */

    $result = $api->addContact($name, $email, $msg);

    if ($result){
        echo '{"msg" : "Project Updated successfully", "Status" : "Success"}';
    }else{
        echo '{"msg" : "Data updation failed", "Status" : "Error"}';
    }
}


?>