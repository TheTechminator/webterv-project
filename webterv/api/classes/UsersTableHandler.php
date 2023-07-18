<?php

class UsersTableHandler {
    private const TABLE_NAME = "users";
    private $pdo;
    private $userData;

    function __construct($userID) {
        $this->connectDB();
        $this->loadUserData($userID);
    }

    private function connectDB () {
        try{
            $this->pdo = new PDO(
                "mysql:host=".HOSTNAME.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                DB_USERNAME, DB_PASSWORD
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) { 
            exit($ex->getMessage()); 
        }
    }

    private function loadUserData ($userID) {
        $sql = "SELECT * FROM " . $this::TABLE_NAME . " WHERE id = " . $userID;
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->userData = $result[0];
    }

    public function getData ($data) {
        if(array_key_exists($data, $this->userData)) {
            return $this->userData[$data];
        }

        return "";
    }

    public function isPublic ($data) {
        if(array_key_exists($data . "_public", $this->userData)) {
            return $this->userData[$data . "_public"];
        }

        return false;
    }

    public function writePublicIndicator ($data) {
        if(array_key_exists($data, $this->userData)) {
            echo $this->userData[$data] ? "checked" : "";
        }

        echo "";
    }

    public function setData ($field, $data) {
        $this->userData[$field] = $data;
    }

    private function updateText ($field) {
        if(isset($_POST[$field])) {
            $this->userData[$field] = urldecode($_POST[$field]);
        }
    }

    private function updateBoolean ($field) {
        if(isset($_POST[$field])) {
            $this->userData[$field] = '1';
        } else {
            $this->userData[$field] = "0";
        }
    }

    public function updateData () {
        if(isset($_POST['update_data'])) {
            $this->updateText('name');
            $this->updateText('mobile');
            $this->updateText('description');
            $this->updateText('email');
            $this->updateText('newsletter');

            $this->updateBoolean('name_public');
            $this->updateBoolean('mobile_public');
            $this->updateBoolean('description_public');
            $this->updateBoolean('email_public');
            $this->updateBoolean('username_public');

            $this->storeData();
        }
    }

    public function deleteUser () {
        if(isset($_POST['user_delete'])) {
            global $ROOT_DIR;
            
            $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id = " . $this->userData['id'] . ";";
            $this->pdo->exec($sql);

            unset($_SESSION["user"]);
            session_commit();

            header("Location: " . $ROOT_DIR);
            exit();
        }
    }

    private function storeData () {
        $sql = "UPDATE " . self::TABLE_NAME . " SET " . $this->getString() . " WHERE id = " . $this->userData['id'] . ";";
        $this->pdo->exec($sql);
    }

    private function getString () {
        $colValue = "";

        foreach ($this->userData as $key => $value) {
            if($colValue == "") {
                $colValue = "$key = '$value'";
            } else {
                $colValue .= ", $key = '$value'";
            }
        }

        return $colValue;
    }
}


?>