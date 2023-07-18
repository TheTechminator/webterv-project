<?php
    /**
     * This file contains the static roots for the site
     */


    $routes = [
        ["/",                       "{$publicDir}/index.php"],
        ["/auth",                   "{$publicDir}/auth.php"],
        ["/settings",               "{$publicDir}/settings.php"],
        ["/user/:id",               "{$publicDir}/user.php"],
        ["/forum/:id",              "{$publicDir}/forum.php"],
        ["/post/:id",               "{$publicDir}/post.php"],
        ["/logout",                 "{$apiDir}/logout.php"],
        ["/user_data",              "{$apiDir}/user_data.php"],
        ["/user_auth",              "{$apiDir}/user_auth.php"],
        ["/api/addData",            "{$apiDir}/addData.php"],
        ["/api/removeData",         "{$apiDir}/removeData.php"],
        ["/api/timer",              "{$apiDir}/TimerTest.php"],  
        ["/api/about",              "{$apiDir}/about.php"],
        ["/api/user/:username",     "{$apiDir}/param.php"],
    ];
?>