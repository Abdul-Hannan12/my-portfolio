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
        $_SESSION['username'] = $data['username'];
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
        $id = $_SESSION['uid'];

        $result = $api->update_profile($name, $email, $contact, $age, $residence, $address, $freelance, $id);
        if ($result) {
            $_SESSION['username'] = $username;
            echo '{"msg" : "Data updated Successfully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }



    if (isset($_POST['MODE']) && $_POST['MODE'] == "addScheduledEntertainment"){
        
        $center = $api->filter_data($_POST['center']);
        $person = $api->filter_data($_POST['person']);
        $desc = $api->filter_data($_POST['description']);
        $status = 1;
        $date = $api->filter_data($_POST['date']);

        // echo $date, $center,$person, $desc, $status;

        $result = $api->add_entertainment($center, $person, $desc, $status, $date, $bid);

        if ($result){
            echo '{"msg" : "Entertainment added successfully", "Status" : "Success"}';
        }else{
            echo '{"msg" : "Data insertion failed ", "Status" : "Error"}'; 
        }

    }

    // if (isset($_POST['MODE']) && $_POST['MODE'] == "profileEdit") {
    //     // $id = $_SESSION['uid'];
    //     $id = 1;
    //     $username = $api->filter_data($_POST['username']);
    //     $email = $api->filter_data($_POST['email']);
    //     $password = $api->filter_data($_POST['password']);
    //     $contact = $api->filter_data($_POST['contact']);
    //     $cnic = $api->filter_data($_POST['cnic']);
    //     $role = $api->filter_data($_POST['role']);
    //     $date = date("Y-m-d h:i:s");
    //     $result = $api->profileEdit($id, $username, $email, $password, $contact, $cnic, $role, $date);

    //     if ($result) {
    //         echo 'edited';
    //     }
    // }

if (isset($_POST['MODE']) && ($_POST['MODE'] == "ManageUsers" || $_POST['MODE'] == "addBranch" || $_POST['MODE'] == "addStock" || $_POST['MODE'] == "edit_stock" || $_POST['MODE'] == "editCenter" || $_POST['MODE'] == "delete_center" || $_POST['MODE'] == "delete_stock")){
        
    if($role == '0' || $role == '1'){ //Check if Users sending Request is Admin or Manager
        if (isset($_POST['MODE']) && $_POST['MODE'] == "ManageUsers") {
            $name = $api->filter_data($_POST['name']);
            $email = $api->filter_data($_POST['email']);
            $password = $api->filter_data($_POST['password']);
            $contact = $api->filter_data($_POST['contact']);
            $cnic = $api->filter_data($_POST['cnic']);
            // $role_of_user = $api->filter_data($_POST['role']);
            // $branch = $api->filter_data($_POST['branch']);
            if($role == '1'){
                $role_of_user = '2';
                $branch = $bid;
            }else{
                $role_of_user = $api->filter_data($_POST['role']);
                $branch = $api->filter_data($_POST['branch']);
            }
            $result = $api->manage_users($name, $email, $password, $contact, $cnic, $role_of_user, $branch);
            if ($result) {
                echo '{"msg" : "User Created SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Email must Unique", "Status" : "Error"}';
            }
        } 
        if (isset($_POST['MODE']) && $_POST['MODE'] == "addBranch") {
            $branch_name = $api->filter_data($_POST['branch_name']);
            $branch_city = $api->filter_data($_POST['branch_city']);
            $branch_head_person = $api->filter_data($_POST['branch_head_person']);
            $result = $api->add_branch($branch_name, $branch_city, $branch_head_person);
    
            if ($result) {
                echo '{"msg" : "Branch Added SuccessFully", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Could not add branch", "Status" : "Error"}';
            }
        }
        if (isset($_POST['MODE']) && $_POST['MODE'] == "addStock") {
            $pro_name = $api->filter_data($_POST['pname']);
            $m_company = $api->filter_data($_POST['mcompany']);
            $m_date = $api->filter_data($_POST['mdate']);
            $exp_date = $api->filter_data($_POST['edate']);
            $price = $api->filter_data($_POST['price']);
            $qty = $api->filter_data($_POST['quantity']);
            $lote = $api->filter_data($_POST['lotnumber']);
            $desc = $api->filter_data($_POST['desp']);
            
            $result = $api->addStock($pro_name, $m_company, $m_date, $exp_date, $price, $qty, $lote, $desc, $uid, $bid);
    
            if ($result) {
                echo '{"msg" : "Stock Added SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Something Went Wrong!", "Status" : "Error"}';
            }
        }

        if (isset($_POST['MODE']) && $_POST['MODE'] == "edit_stock"){

            $id = $api->filter_data($_POST['id']);
            $pro_name = $api->filter_data($_POST['pname']);
            $m_company = $api->filter_data($_POST['mcompany']);
            $m_date = $api->filter_data($_POST['mdate']);
            $exp_date = $api->filter_data($_POST['edate']);
            $price = $api->filter_data($_POST['price']);
            $qty = $api->filter_data($_POST['quantity']);
            $lote = $api->filter_data($_POST['lotnumber']);
            $desc = $api->filter_data($_POST['desp']);
    
            
            $result = $api->edit_Stock($id,$pro_name, $m_company, $m_date, $exp_date, $price, $qty, $lote, $desc);
    
            if ($result) {
                echo '{"msg" : "Stock Updated SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
            }
    
        }

        if (isset($_POST['MODE']) && $_POST['MODE'] == "editCenter"){

            $id = $api->filter_data($_POST['id']);
            $username = $api->filter_data($_POST['username']);
            $email = $api->filter_data($_POST['email']);
            $contact = $api->filter_data($_POST['contact']);
            $whatsapp = $api->filter_data($_POST['whatsapp']);
            $cname = $api->filter_data($_POST['cname']);
            $address = $api->filter_data($_POST['address']);
    
            $result = $api->edit_center($id, $username, $email, $contact, $whatsapp, $cname, $address, $uid, $bid);
    
            if ($result) {
                echo '{"msg" : "Center Updated SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
            }
    
        }
    
        if (isset($_POST['MODE']) && $_POST['MODE'] == "delete_center"){
    
            $id = $api->filter_data($_POST['delete']);
    
            $result = $api->delete_center($id);
    
            if ($result) {
                echo '{"msg" : "Center deleted SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
            }
    
        }
    
        if (isset($_POST['MODE']) && $_POST['MODE'] == "delete_stock"){
    
            $id = $api->filter_data($_POST['delete']);
    
            $result = $api->delete_stock($id);
    
            if ($result) {
                echo '{"msg" : "stock deleted SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
            }
        }
    }else {
        echo '{"msg" : "You dont have enough privileges!", "Status" : "Error"}';
        exit();
    }
}

    // update profile
    

    if (isset($_POST['MODE']) && $_POST['MODE'] == "addCenter") {
        $username = $api->filter_data($_POST['username']);
        $email = $api->filter_data($_POST['email']);
        $contact = $api->filter_data($_POST['contact']);
        $whatsapp = $api->filter_data($_POST['whatsapp']);
        $cname = $api->filter_data($_POST['cname']);
        $address = $api->filter_data($_POST['address']);

        $check = $api->check_center($cname, $bid);

        if ($check > 0){
            echo '{"msg" : "Center Already Exists!", "Status" : "Found"}';
        } else {
            $result = $api->insert_center($username, $email, $contact, $whatsapp, $cname, $address, $uid, $bid);
            if ($result) {
                echo '{"msg" : "Center Added SuccessFully!", "Status" : "Success"}';
            } else {
                echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
            }
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "recovery_consignment") {
        $center = $api->filter_data($_POST['center']);
        $product = $api->filter_data($_POST['product']);
        $quantity = $api->filter_data($_POST['quantity_sold']);
        $paid_amount = $api->filter_data($_POST['price']);

        $result = $api->insert_recovery_Consignment($center, $product, $quantity, $paid_amount, $uid, $bid);

        if ($result) {
            echo '{"msg" : "Center Added SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "edit_entertainment"){

        $id = $api->filter_data($_POST['id']);

        $person = $api->filter_data($_POST['person']);
        $desc = $api->filter_data($_POST['description']);
        $date = $api->filter_data($_POST['date']);

        $result = $api->edit_entertainment($id,  $person, $desc, $date);

        if ($result) {
            echo '{"msg" : "Entertainment Updated SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "delete_entertainment"){

        $id = $api->filter_data($_POST['delete']);

        $result = $api->delete_entertainment($id);

        if ($result) {
            echo '{"msg" : "Entertainment deleted SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }

    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "Product"){

        $id = $api->filter_data($_POST['product_id']);

        $result = $api->product_fetch($id);

        if ($result) {
            echo '{"quantity" : '.$result['quantity'].',"price": '.$result['price'].', "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }

    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "Product_consignment"){

        $id = $api->filter_data($_POST['Consignment_id']);

        $result = $api->fetch_consignments_by_id($id);

        if ($result) {
            echo '{"quantity" : '.$result['quantity'] + $result['squantity'].',"price": '.$result['price'].', "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }

    }
    
    

    
    if (isset($_POST['MODE']) && $_POST['MODE'] == "edit_consignment"){

        $id = $api->filter_data($_POST['id']);
        $quantity = $api->filter_data($_POST['quantity']);
        $paid_amount = $api->filter_data($_POST['paid_amount']);
        $product_price = $api->filter_data($_POST['product_price']);

        $result = $api->edit_consignment($id, $quantity, $paid_amount, $product_price);

        if ($result) {
            echo '{"msg" : "Consignment Updated SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }

    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "delete_consignment"){
        $id = $api->filter_data($_POST['delete']);
        $result = $api->delete_consignment($id);
        if ($result) {
            echo '{"msg" : "Consignment deleted SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "recovery_consignment_fetch"){
        $id = $api->filter_data($_POST['center_id']);
        $result = $api->fetch_consignment_by_center($id);
        if ($result) {
            $a = "<option>Select</option>";
            foreach ($result as $row)
            {
                $a .= "<option value='" . $row['pid'] . "'>" . $row['pname'] . "</option>";
            }
            echo '{"options" : "'.$a.'", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }
    if (isset($_POST['MODE']) && $_POST['MODE'] == "recovery_consignment_fetch_product"){
        $cid = $api->filter_data($_POST['center_id']);
        $pid = $api->filter_data($_POST['product_id']);
        $result = $api->fetch_consignment_by_center_product($cid, $pid);
        if ($result) {
            echo '{"tquantity_sold":"'.$result['tquantity_sold'].'","quantity" : '.$result['tquantity'] .',"price": '.$result['tprice'].',"paid":'.$result['tpaid'].', "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }

    if (isset($_POST['MODE']) && $_POST['MODE'] == "delete_user"){
        $id = $api->filter_data($_POST['delete']);
        $result = $api->delete_user($role, $id);
        if ($result) {
            echo '{"msg" : "User Deleted SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }
    }



    if (isset($_POST['MODE']) && $_POST['MODE'] == "complete_entertainment"){

        $id = $api->filter_data($_POST['complete']);

        $result = $api->complete_entertainment($id);

        if ($result) {
            echo '{"msg" : "Entertainment Completed SuccessFully!", "Status" : "Success"}';
        } else {
            echo '{"msg" : "Something Went Wrong Please Try Again!", "Status" : "Error"}';
        }

    }

}
else{
    echo '{"msg" : "Please Login.", "Status" : "Error"}';
    exit();
}

?>