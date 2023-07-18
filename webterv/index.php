<?php
    require_once "router.class.php";
    require_once "variable.php";
    require_once "site_roots.php";
    require_once "api/includes/db_login.php";
    require_once "api/classes/UsersTableHandler.php";

    $router = new Router($ROOT_DIR, $routes, $_SERVER['REQUEST_URI'], "404.php", Router::BOTH);
    $_PARAMS = $router->execRouting();
    session_start();
    require $router->getDest();
    
?>
