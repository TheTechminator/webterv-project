<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "parts/head.php"; ?>
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/post.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/header.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/sidebar.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/SwiperMenuStyle.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/popupdialog.css">
</head>
<body>
    <?php require "parts/header.php"; ?>

    <div id="mySwiper" class="d-sm-none">
        <div id="mySidenav" class="sidenav">
            <?php require "parts/sidebar.php"; ?>
        </div>
        <div id="swipablePad"></div>
    </div>

    <main>
        <div class="main-container">
            <?php
             if(isset($_SESSION['user'])){
            ?>
            <div class="optionButtons">
                <div class="btn-hover" id="newPostButton">Post létrehozás</div>
                <div class="btn-hover" id="newForumButton">Fórum létrehozás</div>
            </div>
            <?php } ?>

            <?php
                $filterStr = isset($_GET['search']) ? "WHERE posts.title LIKE '%" . $_GET['search'] . "%' OR posts.description LIKE '%" . $_GET['search'] . "%'" : "";
                $stmt = $pdo->prepare("SELECT forums.id as forumID, posts.id as postID, users.id as userID, users.username, forums.name, posts.title, posts.description FROM `posts` inner join `forums` on forums.id = posts.forumId inner join `users` on users.id = posts.userId $filterStr order by posts.id desc");
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="post zoom-in">
                    <div class="post-rate">
                        <img src="<?php echo $ROOT_DIR; ?>/public/svg/hand-thumbs-down.svg" alt="thumb up" class="thumb thumb-up">
                        <span class="counter">100</span>
                        <img src="<?php echo $ROOT_DIR; ?>/public/svg/hand-thumbs-down.svg" alt="thumb down" class="thumb">
                    </div>
                    <div class="post-main">
                        <div class="post-data">
                            <span><a href="<?php echo $ROOT_DIR."/forum/".$row['forumID']; ?>"><?php echo $row['name'];?></a></span>
                            -
                            <span>Posted by <a href="<?php echo $ROOT_DIR."/user/".$row['userID']; ?>"><?php echo $row['username'];?></a></span>
                            <?php if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $row['userID'])){ ?>
                                -
                                <span class="delete-btn post-delete-btn" data-id="<?php echo $row['postID'];?>">Delete Post</span>
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
            <?php } ?>
        </div>
        <?php require "parts/footer.php"; ?>
    </main>
    <?php
        if(isset($_SESSION['user'])){
            require "parts/newpostdialog.php";
            require "parts/newforumdialog.php";
        }
    ?>

    <script src="<?php echo $ROOT_DIR; ?>/public/js/popupdialog.js"></script>
    <script src="<?php echo $ROOT_DIR; ?>/public/js/SwiperMenu.js"></script>
    <script>
        deleteBtn = $$(".post-delete-btn")
        console.log(deleteBtn);
        deleteBtn.forEach(elem =>  {
            console.log(elem)
            console.log(elem.getAttribute("postId"))
            elem.addEventListener("click", (e)=>{
                console.log(elem.getAttribute("postId"));
                let json = new URLSearchParams({
                    type: "post",
                    id: elem.dataset.id,
                })
                if(!confirm("Biztos torolni akarod?")) return;
                console.log(json)
                handleRequest(e, `${basePath}/api/removeData`, json, ()=>window.location.reload())
            })
        })
    </script>
    <script>
        var swiperem = new SwiperMenu({
            swiperContainer:    document.getElementById("mySwiper"),
            swiperSide:         document.getElementById("mySidenav"),
            swipableArea:       document.getElementById("swipablePad"),
            swiperOpen:         document.getElementById("swiperOpenButton"),
            swiperClose:        document.getElementById("swiperCloseButton"),
        });
    </script>
</body>
</html>