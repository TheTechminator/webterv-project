<?php
    require_once "includes/db_login.php";
    require "includes/user.class.php";

    $USR = new Users();
    $errors = array();
    //$errors = array();
    function checkForRequirements($USR, &$errors){
        if($USR->get($_POST['username']) != ""){
            array_push($errors, "A felhasznev foglalt!");
        }
        if($USR->get($_POST['email']) != ""){
            array_push($errors, "Az email cim foglalt!");
        }
        if(empty($_POST['username'])){
            array_push($errors, "Felhasznalonev megadasa kotelezo!");
        }
        if(empty($_POST['email'])){
            array_push($errors, "Email megadasa kotelezo!");
        }
        if(empty($_POST['password'])){
            array_push($errors, "Jelszo megadasa kotelezo!");
        }
        if(strlen($_POST['username']) < 4 || strlen($_POST['username']) > 32){
            array_push($errors, "Felhasznalonev hossza nem megfelelo!");
        }
        if(strlen($_POST['password']) < 8 || strlen($_POST['password']) > 64){
            array_push($errors, "Jelszo hossza nem megfelelo!");
        }
        if($_POST['password'] != $_POST['repassword']){
            array_push($errors, "A ket jelszo nem egyezik meg!");
        }
    }
    function processSignup($USR, &$errors){
        checkForRequirements($USR, $errors);
        if(count($errors) != 0){
            echo '{"type": "fail", "msg":'.json_encode($errors).'}';
            return;
        }
        if($USR->save($_POST['username'], $_POST['email'], $_POST['password'])){
            echo '{"type": "success", "msg":["ok"]}';
        }else{
            echo '{"type": "fail", "msg":"[Belso hiba]"}';
        }
        
    }
    if( $_POST["form_name"] == "login" ){
        echo $USR->login($_POST['username'], $_POST['password'])? '{"type": "success", "msg":""}' : '{"type": "fail", "msg":["A megadott adatok nem megfeleloek"]}';
    }else{
        if($_POST["form_name"] == "signup"){
            processSignup($USR, $errors);
        }
    }
    session_commit();
?>