<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "parts/head.php"; ?>
    <title>Document</title>

    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/post.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/header.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/sidebar.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/forum.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/SwiperMenuStyle.css">
    
</head>
<body>
    <?php include "parts/header.php"; ?>

    <div id="mySwiper" class="d-sm-none">
        <div id="mySidenav" class="sidenav">
            <?php require "parts/sidebar.php"; ?>
        </div>
        <div id="swipablePad"></div>

    </div>

    <main>
        <div class="main-top">
            <div class="forum-background-image" style="background: url('https://styles.redditmedia.com/t5_3sr5cq/styles/bannerBackgroundImage_auewfmsfxn191.png?width=4000&v=enabled&s=d1aff80a7e1aad7feaff3116016dac71c260104d');"></div>
            <?php
                $stmt = $pdo->prepare("SELECT * from `forums` where forums.id = '".$_PARAMS['id']."'");
                $stmt->execute();    
                $forumData = $stmt->fetch();
            ?>
            <div class="forum-info">
                <div class="info-container">
                    <div class="forum-pic">
                        <img src="<?php echo $ROOT_DIR; ?>/public/svg/person-fill-white.svg" alt="User image" title="User image">
                    </div>
                    <div class="title-and-topics-container">
                        <div class="ftitle">
                            <h2><?php echo $forumData['name']?></h2>
                        </div>
                        <div class="ftopics">
                            Játékok/Valorant
                        </div>
                    </div>
                    <div class="join-button-container">
                        <input type="button" class="fjoin-button btn-hover" value="Csatlakozás">
                        <input type="button" class="fdelete-button btn-hover" value="Torles">
                    </div>
                </div>
            </div>
            
            <div class="main-container">
                <div class="forum-posts">
                    <?php
                        $stmt = $pdo->prepare("SELECT forums.id as forumID, posts.id as postID, users.id as userID, users.username, forums.name, posts.title, posts.description FROM `posts` inner join `forums` on forums.id = posts.forumId inner join `users` on users.id = posts.userId where forums.id = ".$_PARAMS['id']." order by posts.id desc");
                        $stmt->execute();
                        
                        while($row = $stmt->fetch()){
                    ?>
                    <div class="post zoom-in">
                        <div class="post-rate">
                            <img src="<?php echo $ROOT_DIR; ?>/public/svg/hand-thumbs-down.svg" alt="thumb up" class="thumb thumb-up">
                            <span class="counter">100</span>
                            <img src="<?php echo $ROOT_DIR; ?>/public/svg/hand-thumbs-down.svg" alt="thumb down" class="thumb">
                        </div>
                        <div class="post-main">
                            <div class="post-data">
                                <span>Posted by <a href="<?php echo $ROOT_DIR."/user/".$row['userID']; ?>"><?php echo $row['username']; ?></a></span>
                                <?php if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $row['userID'])){ ?>
                                    -
                                    <span class="delete-btn post-delete-btn" data-postid="<?php echo $row['postID'];?>">Delete Post</span>
                                <?php } ?>   
                            </div>
                            <a href="<?php echo $ROOT_DIR."/post/".$row['postID']; ?>">
                                <div class="post-title">
                                    <?php echo $row['title'];?>
                                </div>
                                <div class="post-description">
                                    <?php echo str_replace("\n", "<br>", $row['description']);?>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php require "parts/footer.php"; ?>
    </main>

    <script src="<?php echo $ROOT_DIR; ?>/public/js/SwiperMenu.js"></script>
    <script>
        var swiperem = new SwiperMenu({
            swiperContainer:    document.getElementById("mySwiper"),
            swiperSide:         document.getElementById("mySidenav"),
            swipableArea:       document.getElementById("swipablePad"),
            swiperOpen:         document.getElementById("swiperOpenButton"),
            swiperClose:        document.getElementById("swiperCloseButton"),
        });
        $(".fdelete-button").addEventListener("click", (e)=>{
            let json = new URLSearchParams({
                    type: "forum",
                    id: "<?php echo $forumData['id'];?>",
                })
                if(!confirm("Biztos torolni akarod?")) return;
                handleRequest(e, `${basePath}/api/removeData`, json, ()=>redirect(basePath+"/"))
        })
        deletePostBtn = $$(".post-delete-btn")
        deletePostBtn.forEach(elem =>  {
            elem.addEventListener("click", (e)=>{
                let json = new URLSearchParams({
                    type: "post",
                    id: elem.dataset.postid,
                })
                if(!confirm("Biztos torolni akarod?")) return;
                handleRequest(e, `${basePath}/api/removeData`, json, ()=>window.location.reload())
            })
        })
    </script>
</body>
</html>