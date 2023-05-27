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

    function getUserIP() {
        if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
                $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function addContact($name, $email, $message)
    {
        $sql = "INSERT into messages (name, email, msg, ip, created_on) VALUES (:name, :email, :msg, :ip, :created_on)";
        $ip = $this->getUserIP();
        $date = $this->date_now();
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':msg', $message);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':created_on', $date);
        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function fetchUser($uid)
    {
        $sql = "SELECT * from users where uid=:uid";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function fetchSkillsByType($type)
    {
        $sql = "SELECT * from skills WHERE type=:type AND del != '1'";
        $stmt = $this
            ->conn
            ->prepare($sql);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

?>
