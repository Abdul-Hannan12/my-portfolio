<?php
include 'config.php';

class auth extends database
{

    public function date_now()
    {
        date_default_timezone_set("Asia/Karachi");
        return $date = date('Y-m-d h:i:s', time());
    }
    public function filter_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function encPassword($password)
    {
        $salt = ")(*&^%$#(*&^%$#*&^%$#";
        $password_2 = md5($password . $salt);
        return $password_2;
    }
    public function signin($email, $password)
    {
        $sql = "SELECT * from users where email=:email && password=:password";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $password_enc = $this->encPassword($password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_enc);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }
    public function fetch_user_profile($uid)
    {
        $sql = "SELECT * from users where uid=:uid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function fetch_user($email, $password)
    {
        $encPassword = $this->encPassword($password);
        $sql = "SELECT * from users where email=:email and password=:password";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $encPassword);
        $stmt->execute();
        return $stmt->fetch();
    }

    /* ====================  PROJECT DATA START  ==================== */
    public function addProject($project_name, $project_type, $project_desc, $project_url, $project_img)
    {
        $img = $this->upload_project_img($project_type, $project_img);
        if($img){

            $sql = "INSERT into projects (name, type, description, url, img, created_on) VALUES (:name, :type, :desc, :url, :img, :created_on)";
            $stmt = $this->conn->prepare($sql);
            $date = $this->date_now();
            $stmt->bindParam(':name', $project_name);
            $stmt->bindParam(':type', $project_type);
            $stmt->bindParam(':desc', $project_desc);
            $stmt->bindParam(':url', $project_url);
            $stmt->bindParam(':img', $img);
            $stmt->bindParam(':created_on', $date);
            if ($stmt->execute()){
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
        
    }
 
    public function updateProject($project_id, $project_name, $project_type, $project_desc, $project_url, $project_img, $updateImage)
    {
        if($updateImage){
            $this->delete_previous_image($project_id);
            $img = $this->upload_project_img($project_type, $project_img);
            if($img){
                $sql = "UPDATE projects SET name=:name, type=:type, description=:desc, url=:url, img=:img WHERE pid=:pid";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':name', $project_name);
                $stmt->bindParam(':type', $project_type);
                $stmt->bindParam(':desc', $project_desc);
                $stmt->bindParam(':url', $project_url);
                $stmt->bindParam(':img', $img);
                $stmt->bindParam(':pid', $project_id);
                if ($stmt->execute()){
                    return true;
                } else {
                    return false;
                }
            }else{
                return false;
            }
        }else {
            $previousType = $this->getProjectInfo($project_id, 'type');
            $typeChanged = $previousType ? $previousType != $project_type : false;
            if ($typeChanged){
                $moved = $this->moveImageToChangedTypeFolder($project_id, $previousType, $project_type);
                if($moved){
                    $sql = "UPDATE projects SET name=:name, type=:type, description=:desc, url=:url WHERE pid=:pid";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':name', $project_name);
                    $stmt->bindParam(':type', $project_type);
                    $stmt->bindParam(':desc', $project_desc);
                    $stmt->bindParam(':url', $project_url);
                    $stmt->bindParam(':pid', $project_id);
                    if ($stmt->execute()){
                        return true;
                    } else {
                        return false;
                    }
                }
            }else{
                $sql = "UPDATE projects SET name=:name, type=:type, description=:desc, url=:url WHERE pid=:pid";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':name', $project_name);
                    $stmt->bindParam(':type', $project_type);
                    $stmt->bindParam(':desc', $project_desc);
                    $stmt->bindParam(':url', $project_url);
                    $stmt->bindParam(':pid', $project_id);
                    if ($stmt->execute()){
                        return true;
                    } else {
                        return false;
                    }
            }
        }
    }

    public function fetchAllProjects()
    {
        $sql = "SELECT * FROM projects WHERE del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetchProject($id)
    {
        $sql = "SELECT * FROM projects WHERE pid = '$id' AND del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getProjectInfo($id, $col)
    {
        $project = $this->fetchProject($id);
        if ($project){
            $colValue = $project[$col];
            return $colValue;
        }else{
            return false;
        }
    }
    public function deleteProject($id){

        $sql = "UPDATE projects SET del = :del WHERE pid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            $trash_sql = "INSERT INTO trash (table_name, item_id, created_on) VALUES (:table, :id, :date)";
            $date = $this->date_now();
            $table = 'projects';
            $trash_stmt = $this->conn->prepare($trash_sql);
            $trash_stmt->bindParam(':table', $table);
            $trash_stmt->bindParam(':id', $id);
            $trash_stmt->bindParam(':date', $date);
            if($trash_stmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
    public function upload_project_img($type, $file)
    {
        $allow = array('jpg', 'jpeg', 'png');
        $exntension = explode('.', $file['name']);
        $fileActExt = strtolower(end($exntension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = '../../assets/images/projects/'.$type.'/'. $fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($file['size'] > 0 && $file['error'] == 0) {
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    return $fileNew;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public function delete_previous_image($id)
    {
        $previousImageFilename = $this->getProjectInfo($id, 'img');
        $projectType = $this->getProjectInfo($id, 'type');
        if (!empty($previousImageFilename)) {
            $previousImagePath = '../../assets/images/projects/'.$projectType.'/'.$previousImageFilename;
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
    }
    public function moveImageToChangedTypeFolder($id, $oldType, $newType)
    {
        $imgFileName = $this->getProjectInfo($id, 'img');
        $sourcePath = '../../assets/images/projects/'.$oldType.'/'.$imgFileName;
        $destinationPath = '../../assets/images/projects/'.$newType.'/'.$imgFileName;
        $renamed = rename($sourcePath, $destinationPath);
        if ($renamed) {
            return true;
        } else {
            return false;
        }
    }
    /* ====================  PROJECT DATA END  ==================== */
    
    
    /* ====================  SKILL DATA START  ==================== */
    public function addSkill($skill_name, $skill_percentage, $skill_type, $skill_desc)
    {
        $sql = "INSERT into skills (name, percent, description, type, created_on) VALUES (:name, :percent, :desc, :type, :created_on)";
        $stmt = $this->conn->prepare($sql);
        $date = $this->date_now();
        $stmt->bindParam(':name', $skill_name);
        $stmt->bindParam(':percent', $skill_percentage);
        $stmt->bindParam(':desc', $skill_desc);
        $stmt->bindParam(':type', $skill_type);
        $stmt->bindParam(':created_on', $date);
        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
    public function fetchAllSkills()
    {
        $sql = "SELECT * FROM skills WHERE del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function fetchSkill($id)
    {
        $sql = "SELECT * FROM skills WHERE sid = '$id' AND del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function updateSkill($skill_id, $skill_name, $skill_percent, $skill_type, $skill_desc)
    {
        $sql = "UPDATE skills SET name=:name, percent=:percent, description=:desc, type=:type WHERE sid=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $skill_name);
        $stmt->bindParam(':percent', $skill_percent);
        $stmt->bindParam(':desc', $skill_desc);
        $stmt->bindParam(':type', $skill_type);
        $stmt->bindParam(':id', $skill_id);
        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
    public function deleteSkill($id){

        $sql = "UPDATE skills SET del = :del WHERE sid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            $trash_sql = "INSERT INTO trash (table_name, item_id, created_on) VALUES (:table, :id, :date)";
            $date = $this->date_now();
            $table = 'skills';
            $trash_stmt = $this->conn->prepare($trash_sql);
            $trash_stmt->bindParam(':table', $table);
            $trash_stmt->bindParam(':id', $id);
            $trash_stmt->bindParam(':date', $date);
            if($trash_stmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
    /* ====================  SKILL DATA END  ==================== */
    

    /* ====================  PROFILE DATA START  ==================== */
    public function update_profile($name, $email, $contact, $age, $residence, $address, $freelance, $bio, $id){
        $sql = 'UPDATE users SET name = :name, email = :email, contact =:contact, age=:age, residence=:res, freelance=:freelance, bio=:bio, address=:addr WHERE uid = :id ';
        $stmt = $this
        ->conn
        ->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':res', $residence);
        $stmt->bindParam(':freelance', $freelance);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':addr', $address);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    /* ====================  PROFILE DATA END  ==================== */


    /* ====================  TRASH DATA START  ==================== */
    public function getTrash()
    {
        $sql = "SELECT * FROM trash";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getTrashById($id)
    {
        $sql = "SELECT * FROM trash WHERE tid = '$id'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getItem($table, $id)
    {
        $idName = $table[0].'id';
        $sql = "SELECT * FROM $table WHERE $idName = '$id'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function recoverTrash($id)
    {
        $item = $this->getTrashById($id);
        $table = $item['table_name'];
        $idName = $table[0].'id';
        $item_id = $item['item_id'];
        $sql = "UPDATE $table SET del = '0' WHERE $idName = '$item_id'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $result = $stmt->execute();
        if ($result){
            $delSql = "DELETE FROM trash WHERE tid = '$id'";
            $delStmt = $this
            ->conn
            ->prepare($delSql);
            if($delStmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function deleteTrash($id)
    {
        $item = $this->getTrashById($id);
        $table = $item['table_name'];
        $idName = $table[0].'id';
        $item_id = $item['item_id'];
        $sql = "DELETE FROM $table WHERE $idName = '$item_id'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $result = $stmt->execute();
        if ($result){
            $delSql = "DELETE FROM trash WHERE tid = '$id'";
            $delStmt = $this
            ->conn
            ->prepare($delSql);
            if($delStmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function clearTrash()
    {
        $trash = $this->getTrash();
        $deleted = false;
        foreach($trash as $item){
            $deleted = $this->deleteTrash($item['tid']);
        }
        if ($deleted){
            return true;
        }else{
            return false;
        }
    }
    /* ====================  TRASH DATA END  ==================== */

    /* ====================  ABOUT DATA START  ==================== */
    public function fetchAboutParas($uid)
    {
        $sql = "SELECT * FROM about_paras WHERE uid=:uid AND del != 1 ORDER BY about_order ASC";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function addAbout($para, $order, $length, $uid)
    {
        $sql = "INSERT INTO about_paras (para, about_order, length, uid, created_on) VALUES (:para, :order, :length, :uid, :date)";
        $date = $this->date_now();
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':para', $para);
        $stmt->bindParam(':order', $order);
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':date', $date);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateAbout($aid, $para, $order, $length)
    {
        $sql = "UPDATE about_paras SET para=:para, about_order=:order, length=:length WHERE aid=:id";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':id', $aid);
        $stmt->bindParam(':para', $para);
        $stmt->bindParam(':order', $order);
        $stmt->bindParam(':length', $length);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function deleteAbout($id){

        $sql = "UPDATE about_paras SET del = :del WHERE aid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            $trash_sql = "INSERT INTO trash (table_name, item_id, created_on) VALUES (:table, :id, :date)";
            $date = $this->date_now();
            $table = 'about_paras';
            $trash_stmt = $this->conn->prepare($trash_sql);
            $trash_stmt->bindParam(':table', $table);
            $trash_stmt->bindParam(':id', $id);
            $trash_stmt->bindParam(':date', $date);
            if($trash_stmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
    /* ====================  ABOUT DATA END  ==================== */
    
}
?>
