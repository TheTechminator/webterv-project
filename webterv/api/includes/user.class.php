<?php
    class Users {
        private $pdo = null;
        private $query = null;
        public $error = null;
        public $errors = [];
        public const TABLE_NAME = "users";

        function __construct () {
            try {
                $this->pdo = new PDO(
                    "mysql:host=".HOSTNAME.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                    DB_USERNAME, DB_PASSWORD
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (Exception $ex) { 
                exit($ex->getMessage()); 
            }
        }
/*
        private function createTable () {
            $sql = 
                "CREATE TABLE IF NOT EXISTS `" . $this::TABLE_NAME . "` (
                    id INT NOT NULL AUTO_INCREMENT, 
                    username VARCHAR(250) NOT NULL,
                    email VARCHAR(250) NOT NULL,
                    password VARCHAR(250) NOT NULL,
                    fullname VARCHAR(250) NOT NULL,
                    phone VARCHAR(20) NOT NULL,
                    description TEXT NOT NULL,
                    newsletter BOOLEAN NOT NULL,
                    PRIMARY KEY (id)
                )
                ENGINE = InnoDB";

            $this->query = $this->pdo->prepare($sql);
            $this->query->execute();

            echo "Megvan";
        }*/

        // Adatbazis kapcsolat bezarasa
        function __destruct () {
            $this->query = null;
            $this->pdo = null;
        }
        // Felhasznalo kikerese id alapjan
        function get ($id) {
            $sql = "SELECT * FROM permission INNER JOIN permission_level on permission_level.id = permission.level RIGHT JOIN users on permission.userId = users.id WHERE `username`='".$id."' or `email`='".$id."'"; 
            //$sql = "SELECT * FROM `users` WHERE `username`=? or `email`=?";
            $this->query = $this->pdo->prepare($sql);
            $this->query->execute();
            return $this->query->fetch();
        }

        //Bejelentkezes
        function login ($email, $password) {
            
            //$this->getPermission($email);
            //be van-e jelentkezve
            if (isset($_SESSION["user"])) { return true; }

            // felhasznalo kikerese adatbazisbol
            $user = $this->get($email);
            if (!is_array($user)) { return false; }
            //print_r($user);
            // felhasznalo hitelesitese
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = [];
                foreach ($user as $i=>$b) {
                    if ($i!="password" && !is_numeric($i)) $_SESSION["user"][$i] = $b;
                }
                return true;
            }
            return false;
        }

        // Felhasznalo beirasa adatbazisba
        function save ($username, $email, $password, $id=null) {
            $pass = password_hash($password, 1);
            if ($id===null) {
                $sql = "INSERT INTO `" . $this::TABLE_NAME . "` (`username`, `email`, `password`) VALUES (?, ?, ?)";
                $data = [$username, $email, $pass];
            }/*
            $sql = "UPDATE `users` SET `user_name`=?, `user_email`=?, `user_password`=? WHERE `user_id`=?";
            $data = [$name, $email, password_hash($pass, 1), $id];*/

            try {
                $this->query = $this->pdo->prepare($sql);
                $this->query->execute($data);
            } catch (Exception $ex) {
                $this->error = $ex->getMessage();
                return false;
            }
            $this->login($email, $password);
            return true;
        }
    }
?>