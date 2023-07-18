<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "parts/head.php"; ?>
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/colors.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/userPage.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/header.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/base.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/flex.css">
    <title>Document</title>
</head>
<body>
    <?php include "parts/header.php"; ?>
    <?php
        $uth = new UsersTableHandler($_PARAMS['id']);
    ?>

    <main>
        <div id="top">
            <div id="section1">
                <img src="<?php echo $ROOT_DIR; ?>/public/svg/person-fill-black.svg" alt="User image">
            </div>
            <div id="section2">

                <table class="w-100">
                    <caption>Felhasználó adatai</caption>
                    <thead>
                        <th id="type">Adat típusa</th>
                        <th id="value">Adat értéke</th>
                    </thead>
                    <tbody class="w-100">
                        <?php
                            if($uth->isPublic("name")) {
                                echo "
                                    <tr class='w-100'>
                                        <td headers='type'>Teljes név:</td>
                                        <td headers='value'>{$uth->getData('name')}</td>
                                    </tr>
                                ";
                            }
        
                            if($uth->isPublic("username")) {
                                echo "
                                    <tr class='w-100'>
                                        <td headers='type'>Felhasználónév:</td>
                                        <td headers='value'>{$uth->getData('username')}</td>
                                    </tr>
                                ";
                            }
        
                            if($uth->isPublic("email")) {
                                echo "
                                    <tr class='w-100'>
                                        <td headers='type'>Email:</td>
                                        <td headers='value'>{$uth->getData('email')}</td>
                                    </tr>
                                ";
                            }
        
                            if($uth->isPublic("mobile")) {
                                echo "
                                    <tr class='w-100'>
                                        <td headers='type'>Telefonszám:</td>
                                        <td headers='value'>{$uth->getData('mobile')}</td>
                                    </tr>
                                ";
                            }
        
                            if($uth->isPublic("description")) {
                                echo "
                                    <tr class='w-100'>
                                        <td headers='type'>Bemutatkozó szöveg:</td>
                                        <td headers='value'>{$uth->getData('description')}</td>
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="bottom">
            <h3>Posts</h3>
            
            <div id="userPosts">
                <?php
                    $posts = $pdo->prepare("SELECT id, title from posts where posts.userId=".$_PARAMS['id']);
                    $posts->execute();
                    while($post = $posts->fetch()){
                ?>
                    <a href="<?php echo $ROOT_DIR."/post/".$post['id']; ?>" class="w-100 zoom-in">
                        <?php echo $post['title'];?>
                        <span class="postRating">10</span>
                    </a>
                    
            <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>