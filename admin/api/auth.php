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

    // Fetching Data.........
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
    public function fetch_user_count($email)
    {
        $sql = "SELECT * from users where email=:email";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function fetch_branch($uid)
    {
        $sql = "SELECT * from branch where uid=:uid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetch();
    }

    // --------------------     PROJECT DATA      ------------------------- //
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
            return true;
        }else{
            return false;
        }

    }
    

    public function insert_recovery_Consignment($center, $product, $quantity, $amount, $uid, $bid)
    {
        $sql = "INSERT into consigmentrecovery (cid, pid, quantitySold, amountRecived, uid, bid, created_on) VALUES (:cid, :pid, :quantity, :paid, :uid, :bid, :created_on)";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $date = $this->date_now();
        $stmt->bindParam(':cid', $center);
        $stmt->bindParam(':pid', $product);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':paid', $amount);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':created_on', $date);
        if ($stmt->execute()){
            $data = $this->fetch_consignment_by_center_product($center, $product);
            $pre_paid = $data['paid'] + $amount;
            $sold_quantity = $data['sold_quantity'] + $quantity;
            $sql = "UPDATE consigment set sold_quantity=:sold_quantity, paid = :paid where cid=:cid and pid=:pid";
            $stmt = $this
            ->conn
            ->prepare($sql);
            $stmt->bindParam(':cid', $center);
            $stmt->bindParam(':pid', $product);
            $stmt->bindParam(':paid', $pre_paid);
            $stmt->bindParam(':sold_quantity', $sold_quantity);
            if ($stmt->execute()){
                return true;
            }else{
                return false;
            }
        
        } else {
            return false;
        }

    }

    public function fetch_consignments()
    {
        $sql = "SELECT c.csid, c.quantity, c.paid, c.price, cs.cname, s.pname FROM consigment c INNER JOIN centers cs on c.cid = cs.cid INNER JOIN stocks s on c.pid = s.pid  WHERE c.del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetch_consignments_by_branch($bid)
    {
        $sql = "SELECT c.csid, c.quantity, c.paid, c.price, cs.cname, s.pname FROM consigment c INNER JOIN centers cs on c.cid = cs.cid INNER JOIN stocks s on c.pid = s.pid  WHERE c.del != '1' AND c.bid = :bid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function fetch_consignments_by_id($id)
    {
        $sql = "SELECT c.quantity, c.price, s.quantity as squantity FROM consigment c LEFT JOIN stocks s on s.pid = c.pid WHERE csid = :id";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function fetch_consignment_by_center($id)
    {
        $sql = "SELECT c.pid, s.pname from consigment c LEFT JOIN stocks s on c.pid = s.pid  WHERE cid = :id GROUP BY c.pid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function fetch_consignment_by_center_product($cid, $pid)
    {
        $sql = "SELECT *, COUNT(*) as cnt, SUM(sold_quantity) as tquantity_sold, SUM(quantity) as tquantity, SUM(price) as tprice, SUM(paid) as tpaid FROM consigment  WHERE cid = :cid AND pid = :pid GROUP BY cid , pid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':cid', $cid);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function check_consignment_in_db($center, $product){
        $sql = "SELECT * from consigment WHERE cid = :cid AND pid = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cid', $center);
        $stmt->bindParam(':pid', $product);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }

    public function edit_consignment($id, $quantity, $paid_amount, $product_amount)
    {
        
        $sql = "UPDATE consigment SET quantity = :quantity, paid = :paid_amount, price = :product_amount where csid = :id";
        $stmt = $this
        ->conn
        ->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':paid_amount', $paid_amount);
        $stmt->bindParam(':product_amount', $product_amount);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_consignment($id){

        $sql = "UPDATE consigment SET del = :del where csid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    // --------------------     STOCK DATA      ------------------------- //
    public function addStock($pro_name, $m_company, $m_date, $exp_date, $price, $qty, $lote, $desc, $uid, $bid)
    {
        $date = $this->date_now();
        // echo $date;
        $sql = "insert into stocks (pname, mcompany, mdate, edate, price, quantity, lotnumber, desp, uid, bid, created_on) values(:pro_name,:m_company,:m_date,:exp_date,:price,:qty,:lote,:desc, :uid, :bid, :created_on) ";

        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':pro_name', $pro_name);
        $stmt->bindParam(':m_company', $m_company);
        $stmt->bindParam(':m_date', $m_date);
        $stmt->bindParam(':exp_date', $exp_date);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':qty', $qty);
        $stmt->bindParam(':lote', $lote);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':created_on', $date);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function fetch_stocks(){
        $sql = "SELECT * FROM stocks s LEFT JOIN branch b on b.bid = s.bid where del != '1' ORDER by pid DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function edit_stock($id, $pro_name, $m_company, $m_date, $exp_date,$price,$qty, $lote,$desc)
    {
        
        $sql = "UPDATE stocks SET pname =:pro_name,mcompany=:m_company,mdate=:m_date,edate=:exp_date,price=:price,quantity=:qty,lotnumber=:lote,desp=:desc WHERE pid = :id";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':pro_name', $pro_name);
        $stmt->bindParam(':m_company', $m_company);
        $stmt->bindParam(':m_date', $m_date);
        $stmt->bindParam(':exp_date', $exp_date);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':qty', $qty);
        $stmt->bindParam(':lote', $lote);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_stock($id){

        $sql = "UPDATE stocks SET del = :del where pid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
    public function fetch_stocks_by_branch($bid)
    {
        $sql = "SELECT * FROM stocks s LEFT JOIN branch b on b.bid = s.bid WHERE del != '1'  AND s.bid = :bid ORDER by s.pid DESC";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // --------------------     MANAGE USERS      ------------------------- //
    public function manage_users($name, $email, $password, $contact, $cnic, $role_of_user, $bid)
    {
        $users = $this->fetch_user_count($email);
        if ($users >= 1)
        {
            return false;
        }
        else
        {
            $date = $this->date_now();
            $sql = "INSERT into users (username, email, password, contact, cnic, role, bid, created_on) VALUES (:username, :email, :password, :contact, :cnic, :role,:bid, :created_on)";
            $stmt = $this
                ->conn
                ->prepare($sql);
            $password_enc = $this->encPassword($password);
            $stmt->bindParam(':username', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_enc);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':cnic', $cnic);
            $stmt->bindParam(':role', $role_of_user);
            $stmt->bindParam(':bid', $bid);
            $stmt->bindParam(':created_on', $date);
            if ($stmt->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    public function fetch_all_user()
    {
        $sql = "SELECT *, u.uid as id from users u left JOIN branch b on u.bid= b.bid where  u.del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();        
    }

    public function fetch_all_branch_users($bid)
    {
        $sql = "SELECT *, u.uid as id from users u left JOIN branch b on u.bid= b.bid where role = '2' AND u.del != '1' AND u.bid = :bid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // update profile by id
    public function update_profile($uname, $email, $contact, $uid){
        $sql = 'UPDATE users SET username = :uname, email = :email, contact =:contact where uid = :id ';
        $stmt = $this
                ->conn
                ->prepare($sql);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':id', $uid);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_user($role, $id){

        if ($role == 0){

            $sql = "UPDATE users SET del = :del where uid = :id";
            $del = '1';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':del', $del);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }
    }


    // --------------------     ENTERTAINMENT DATA      ------------------------- //
    public function add_entertainment($center, $person, $desc, $status, $date1, $bid)
    {
        
        $sql = "INSERT INTO entertainment (cid, person, desp, status, date, bid, created_on) VALUE (:cid, :person, :desp, :status, :date, :bid, :created_on)";
        $stmt = $this
        ->conn
        ->prepare($sql);

        $date = $this->date_now();
        $stmt->bindParam(':cid', $center);
        $stmt->bindParam(':person', $person);
        $stmt->bindParam(':desp', $desc);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':date', $date1);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':created_on', $date);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            echo $person;
            return false;
        }
    }
    
    public function fetch_entertainments()
    {
        $sql = "SELECT * FROM entertainment e LEFT JOIN centers c on c.cid = e.cid  WHERE e.del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetch_entertainments_by_branch($bid)
    {
        $sql = "SELECT * FROM entertainment e LEFT JOIN centers c on c.cid = e.cid  WHERE e.del != '1' AND e.bid = :bid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function edit_entertainment($id,  $person, $desc, $date)
    {
        
        $sql = "UPDATE entertainment SET  person = :person, desp=:desp, date = :date where eid = :id";
        $stmt = $this
        ->conn
        ->prepare($sql);


        $stmt->bindParam(':person', $person);
        $stmt->bindParam(':desp', $desc);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_entertainment($id){

        $sql = "UPDATE entertainment SET del = :del where eid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function complete_entertainment($id){

        $sql = "UPDATE entertainment SET status = :status where eid = :id";
        $status = '0';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }


    // --------------------     CENTER DATA      ------------------------- //
    public function insert_center($username, $email, $contact, $whatsapp, $cname, $address, $uid, $bid)
    {
        
        $sql = "INSERT into centers (username, email, contact, whatsapp, cname, address, uid, bid, created_on) VALUES (:username, :email, :contact, :whatsapp, :cname, :address, :uid, :bid,:created_on)";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $date = $this->date_now();
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':whatsapp', $whatsapp);
        $stmt->bindParam(':cname', $cname);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':created_on', $date);

        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function check_center($cname, $bid){
        $sql = "SELECT * from centers where cname=:cname AND bid=:bid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':cname', $cname);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function fetch_center(){
        $sql = "SELECT * FROM centers WHERE del != '1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetch_center_by_branch($bid)
    {
        $sql = "SELECT * FROM centers WHERE del != '1' AND bid = :bid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetch_center_by_id($id)
    {
        $sql = "SELECT * FROM centers where cid = :id";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function edit_center($id, $username, $email, $contact, $whatsapp, $cname, $address, $uid, $bid)
    {
        
        $sql = "UPDATE centers SET username = :username, email = :email, contact = :contact, whatsapp = :whatsapp, cname = :cname, address = :address, uid = :uid, bid = :bid where cid = :id";
        $stmt = $this
        ->conn
        ->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':whatsapp', $whatsapp);
        $stmt->bindParam(':cname', $cname);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_center($id){

        $sql = "UPDATE centers SET del = :del where cid = :id";
        $del = '1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':del', $del);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }


    // --------------------     BRANCH DATA      ------------------------- //
    public function add_branch($branch_name, $branch_city, $branch_head_person)
    {
        $sql = "INSERT INTO branch (branch_name, city, uid) VALUE (:branch_name, :branch_city, :branch_head_person)";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':branch_city', $branch_city);
        $stmt->bindParam(':branch_head_person', $branch_head_person);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    // fetch all branches
    public function fetch_all_branches(){
        $sql = 'SELECT * FROM branch';
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetch_user_by_roleBrnach($role)
    {
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function product_fetch($id)
    {
        $sql = "SELECT * FROM stocks WHERE pid = :id";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function product_update($id, $quantity)
    {
        $sql = "UPDATE stocks set quantity= :quantity WHERE pid = :id";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();;
    }
    // Dashboard
    public function total_Centers()
    {
       $sql = "SELECT * from centers where del != '1'";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function total_Centers_branch($bid)
    {
       $sql = "SELECT * from centers where del != '1' AND bid = :bid";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function total_Consignment()
    {
       $sql = "SELECT * from consigment where del != '1'";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function total_Consignment_branch($bid)
    {
       $sql = "SELECT * from consigment where del != '1' AND bid = :bid";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function total_Consignment_recoverd()
    {
       $sql = "SELECT IFNULL(SUM(paid), 0) as totalpaid from consigment where del != '1'";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function total_Consignment_recoverd_branch($bid)
    {
       $sql = "SELECT IFNULL(SUM(paid), 0) as totalpaid from consigment where del != '1' AND bid = :bid";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function total_Entertainments()
    {
       $sql = "SELECT * from entertainment  where del != '1'";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function total_Entertainments_branch($bid)
    {
       $sql = "SELECT * from entertainment where del != '1' AND bid = :bid";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function display_entertainments()
    {
       date_default_timezone_set("Asia/Karachi");
       $date = date('Y-m-d');   
       $sql = "SELECT * from entertainment e left JOIN branch b on e.bid = b.bid  where del != '1' AND date = :date";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function display_entertainments_branch($bid)
    {
       date_default_timezone_set("Asia/Karachi");
       $date = date('Y-m-d');   
       $sql = "SELECT * from entertainment e left JOIN branch b on e.bid = b.bid  where del != '1' AND e.bid = :bid AND date = :date";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function Expiry()
    {
       date_default_timezone_set("Asia/Karachi");
       $date = date('Y');   
       $sql = "SELECT * FROM stocks s LEFT JOIN branch b on s.bid = b.bid WHERE s.del != '1' AND YEAR(edate) = :date ORDER BY `s`.`edate` DESC";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function Expiry_branch($bid)
    {
       date_default_timezone_set("Asia/Karachi");
       $date = date('Y');   
       $sql = "SELECT * FROM stocks s LEFT JOIN branch b on s.bid = b.bid WHERE s.del != '1' AND YEAR(edate) = :date AND s.bid = :bid ORDER BY `s`.`edate` DESC";
       $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':bid', $bid);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

?>
