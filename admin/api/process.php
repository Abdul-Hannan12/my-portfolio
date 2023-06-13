<?php

ob_start();
session_start();
include ('auth.php');
$api = new auth();

if (isset($_POST['MODE']) && $_POST['MODE'] == "Signin") {
    $email = $api->filter_data($_POST['email']);
    $password = $api->filter_data($_POST['password']);
    $row = $api->signin($email, $password);
    if($row > 0){
        $data = $api->fetch_user($email, $password);
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['uid'] = $data['uid'];
        $_SESSION['username'] = $data['name'];
        echo '{"msg" : "Logged In SuccessFully", "Status" : "Success"}';
       exit();
    }else{
        echo '{"msg" : "Incorrect Email or Password", "Status" : "Error"}';
        exit();
    }
}

if(isset($_SESSION['isLoggedIn'])){
    $uid = $_SESSION['uid'];

    if (isset($_POST['MODE']) && $_POST['MODE'] == "addProject"){
        
        $project_url = '';
        
        $project_img = $_FILES['img'];
        $project_name = $api->filter_data($_POST['pname']);
        $project_type = $api->filter_data($_POST['type']);
        $project_desc = $api->filter_data($_POST['desc']);

        if($project_type == 'web' || $project_type == 'other'){
            $project_url = $api->filter_data($_POST['url']);
        }
        
        $result = $api->addProject($project_name, $project_type, $project_desc, $project_url, $project_img);

        if ($result){
            echo '{"msg" : "Project added successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data insertion failed", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "getProject"){
        
        $pid = $_POST['pid'];
        
        $result = $api->fetchProject($pid);

        if ($result){
            echo json_encode($result);
        }else{
            echo '{"msg" : "Data Could not be fetched", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateProject"){
        
        $project_url = '';
        
        $project_id = $api->filter_data($_POST['id']);

        $project_name = $api->filter_data($_POST['title']);
        $project_type = $api->filter_data($_POST['type']);
        $project_desc = $api->filter_data($_POST['desc']);

        if($project_type == 'web' || $project_type == 'other'){
            $project_url = $api->filter_data($_POST['url']);
        }

        if(isset($_FILES['img'])){
            $result = $api->updateProject($project_id, $project_name, $project_type, $project_desc, $project_url, $_FILES['img'], true);
        }else{
            $result = $api->updateProject($project_id, $project_name, $project_type, $project_desc, $project_url, '', false);
        }

        if ($result){
            echo '{"msg" : "Project Updated successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data updation failed", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteProject"){
        
        $project_id = $api->filter_data($_POST['del']);

        $result = $api->deleteProject($project_id);

        if ($result){
            echo '{"msg" : "Project Deleted successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data deletion failed", "Status" : "Error"}';
        }

    }

    
    if (isset($_POST['MODE']) && $_POST['MODE'] == "addSkill"){
        
        $skill_name = $api->filter_data($_POST['name']);
        $skill_percentage = $api->filter_data($_POST['percent']);
        $skill_type = $api->filter_data($_POST['type']);
        $skill_desc = $api->filter_data($_POST['desc']);

        $result = $api->addSkill($skill_name, $skill_percentage, $skill_type, $skill_desc);

        if ($result){
            echo '{"msg" : "Project added successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data insertion failed", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "getSkill"){
        
        $id = $_POST['id'];
        
        $result = $api->fetchSkill($id);

        if ($result){
            echo json_encode($result);
        }else{
            echo '{"msg" : "Data Could not be fetched", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateSkill"){
        
        $skill_id = $api->filter_data($_POST['id']);
        $skill_name = $api->filter_data($_POST['name']);
        $skill_percent = $api->filter_data($_POST['percent']);
        $skill_type = $api->filter_data($_POST['type']);
        $skill_desc = $api->filter_data($_POST['desc']);

        $result = $api->updateSkill($skill_id, $skill_name, $skill_percent, $skill_type, $skill_desc);

        if ($result){
            echo '{"msg" : "Skill Updated successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data updation failed", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteSkill"){
        
        $skill_id = $api->filter_data($_POST['del']);

        $result = $api->deleteSkill($skill_id);

        if ($result){
            echo '{"msg" : "Skill Deleted successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data deletion failed", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateProfile") {

        $name = $api->filter_data($_POST['name']);
        $email = $api->filter_data($_POST['email']);
        $contact = $api->filter_data($_POST['contact']);
        $age = $api->filter_data($_POST['age']);
        $residence = $api->filter_data($_POST['residence']);
        $address = $api->filter_data($_POST['address']);
        $freelance = $api->filter_data($_POST['freelance']);
        $bio = $api->filter_data($_POST['bio']);
        $id = $_SESSION['uid'];

        $result = $api->update_profile($name, $email, $contact, $age, $residence, $address, $freelance, $bio, $id);
        if ($result) {
            $_SESSION['username'] = $username;
            echo '{"msg" : "Data updated Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "recoverTrash") {

        $id = $_POST['id'];

        $result = $api->recoverTrash($id);
        
        if ($result) {
            echo '{"msg" : "Data Recovered Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteTrash") {

        $id = $_POST['del'];

        $result = $api->deleteTrash($id);

        if ($result) {
            echo '{"msg" : "Data Deleted Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "clearTrash") {

        $result = $api->clearTrash();

        if ($result) {
            echo '{"msg" : "Data Deleted Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "addParagraph") {

        $para = $api->filter_data($_POST['para']);
        $order = $api->filter_data($_POST['order']);
        $length = $api->filter_data($_POST['length']);
        $uid = $_SESSION['uid'];

        $result = $api->addAbout($para, $order, $length, $uid);
        if ($result) {
            echo '{"msg" : "Data Added Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateAbout") {

        $para = $api->filter_data($_POST['para']);
        $order = $api->filter_data($_POST['order']);
        $length = $api->filter_data($_POST['length']);
        $id = $api->filter_data($_POST['id']);

        $result = $api->updateAbout($id, $para, $order, $length);
        if ($result) {
            echo '{"msg" : "Data updated Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteAbout") {

        $id = $api->filter_data($_POST['id']);

        $result = $api->deleteAbout($id);
        if ($result) {
            echo '{"msg" : "Data Deleted Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    
    if (isset($_POST['MODE']) && $_POST['MODE'] == "getEducation"){
        
        $id = $_POST['id'];
        
        $result = $api->fetchEducation($id);

        if ($result){
            echo json_encode($result);
        }else{
            echo '{"msg" : "Data Could not be fetched", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "addEducation") {

        $institute = $api->filter_data($_POST['institute']);
        $session = $api->filter_data($_POST['session']);
        $order = $api->filter_data($_POST['order']);
        $desc = $api->filter_data($_POST['desc']);

        $result = $api->addEducation($institute, $session, $desc, $order);
        if ($result) {
            echo '{"msg" : "Data Added Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateEducation") {

        $institute = $api->filter_data($_POST['institute']);
        $session = $api->filter_data($_POST['session']);
        $order = $api->filter_data($_POST['order']);
        $desc = $api->filter_data($_POST['desc']);
        $id = $api->filter_data($_POST['id']);

        $result = $api->UpdateEducation($id, $institute, $session, $desc, $order);
        if ($result) {
            echo '{"msg" : "Data updated Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteEducation") {

        $id = $api->filter_data($_POST['id']);

        $result = $api->deleteEducation($id);
        if ($result) {
            echo '{"msg" : "Data Deleted Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "getService"){
        
        $id = $_POST['id'];
        
        $result = $api->fetchService($id);

        if ($result){
            echo json_encode($result);
        }else{
            echo '{"msg" : "Data Could not be fetched", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "addService") {

        $name = $api->filter_data($_POST['name']);
        $order = $api->filter_data($_POST['order']);
        $desc = $api->filter_data($_POST['desc']);

        $result = $api->addService($name, $desc, $order);
        if ($result) {
            echo '{"msg" : "Data Added Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateService") {

        $name = $api->filter_data($_POST['name']);
        $order = $api->filter_data($_POST['order']);
        $desc = $api->filter_data($_POST['desc']);
        $id = $api->filter_data($_POST['id']);

        $result = $api->updateService($id, $name, $desc, $order);
        if ($result) {
            echo '{"msg" : "Data updated Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteService") {

        $id = $api->filter_data($_POST['id']);

        $result = $api->deleteService($id);
        if ($result) {
            echo '{"msg" : "Data Deleted Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "getExperience"){
        
        $id = $_POST['id'];
        
        $result = $api->fetchExperience($id);

        if ($result){
            echo json_encode($result);
        }else{
            echo '{"msg" : "Data Could not be fetched", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "addExperience") {

        $org = $api->filter_data($_POST['organization']);
        $duration = $api->filter_data($_POST['duration']);
        $order = $api->filter_data($_POST['order']);
        $desc = $api->filter_data($_POST['desc']);

        $result = $api->addExperience($org, $duration, $desc, $order);
        if ($result) {
            echo '{"msg" : "Data Added Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "updateExperience") {

        $org = $api->filter_data($_POST['organization']);
        $duration = $api->filter_data($_POST['duration']);
        $order = $api->filter_data($_POST['order']);
        $desc = $api->filter_data($_POST['desc']);
        $id = $api->filter_data($_POST['id']);

        $result = $api->updateExperience($id, $org, $duration, $desc, $order);
        if ($result) {
            echo '{"msg" : "Data updated Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "deleteExperience") {

        $id = $api->filter_data($_POST['id']);

        $result = $api->deleteExperience($id);
        if ($result) {
            echo '{"msg" : "Data Deleted Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

}

?>