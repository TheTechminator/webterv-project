<?php
    require "db_auth_params.php";

    try{
        $pdo = new PDO(
            "mysql:host=".HOSTNAME.";dbname=".DB_NAME.";charset=".DB_CHARSET,
            DB_USERNAME, DB_PASSWORD
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $ex) { 
        exit($ex->getMessage()); 
    }
?> 