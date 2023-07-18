<?php 
    if(isset($_POST['value']) && $_POST['value'] != "logout"){
        if(session_status() == PHP_SESSION_NONE)session_start();
        unset($_SESSION["user"]);
        $_SESSION["user"]["name"]="ziza";
        session_commit();
        
    }else{
        if(session_status() == PHP_SESSION_NONE)session_start();
        unset($_SESSION["user"]);
        session_commit();
        echo("logout success");
        header("Location: ".$ROOT_DIR."/");
    }
    
?>