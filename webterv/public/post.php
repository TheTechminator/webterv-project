<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "parts/head.php"; ?>
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/post.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/header.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/sidebar.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/SwiperMenuStyle.css">
    <title>Document</title>
</head>
<body>
    <?php include "parts/header.php"; ?>
    <?php 
        $test = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Volutpat maecenas volutpat blandit aliquam. Vel pretium lectus quam id leo in vitae turpis massa. Nec feugiat in fermentum posuere urna nec tincidunt praesent semper. Ut eu sem integer vitae justo eget magna fermentum iaculis. Ac placerat vestibulum lectus mauris ultrices. Nulla pharetra diam sit amet nisl suscipit adipiscing. Lectus urna duis convallis convallis tellus id interdum velit. Euismod in pellentesque massa placerat duis ultricies lacus sed turpis. Sit amet consectetur adipiscing elit duis tristique sollicitudin. Purus faucibus ornare suspendisse sed nisi lacus. Vehicula ipsum a arcu cursus vitae. Tempor commodo ullamcorper a lacus. Velit dignissim sodales ut eu sem integer vitae justo. Pulvinar elementum integer enim neque volutpat ac tincidunt vitae semper. Pharetra pharetra massa massa ultricies. Sapien faucibus et molestie ac feugiat sed lectus.";
    ?>
    <div id="mySwiper" class="d-sm-none">
        <div id="mySidenav" class="sidenav">
            <?php require "parts/sidebar.php"; ?>
        </div>
        <div id="swipablePad"></div>
    </div>

    <main>
        <div class="main-container">
            <?php
                $stmt = $pdo->prepare("SELECT forums.id as forumID, posts.id as postID, users.id as userID, users.username, forums.name, posts.title, posts.description FROM `posts` inner join `forums` on forums.id = posts.forumId inner join `users` on users.id = posts.userId where posts.id=".$_PARAMS['id']." order by posts.id desc");
                $stmt->execute();
                $postData = $stmt->fetch();
            ?>
            <a href="<?php echo $ROOT_DIR."/forum/".$postData['forumID']; ?>" id="backToButton">Back to test</a>
            <div class="post border-bottom-radius-0 margin-bottom-0 opacity-1-imp">
                <div class="post-rate">
                    <img src="<?php echo $ROOT_DIR; ?>/public/svg/hand-thumbs-down.svg" alt="" class="thumb thumb-up">
                    <span class="counter">10</span>
                    <img src="<?php echo $ROOT_DIR; ?>/public/svg/hand-thumbs-down.svg" alt="" class="thumb">
                </div>
                <div class="post-main">
                    <div class="post-data">
                        <span>Posted by <a href="<?php echo $ROOT_DIR."/user/".$postData['userID']; ?>"><?php echo $postData['username']; ?></a></span>
                        <?php if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $postData['userID'])){ ?>
                            -
                            <span class="delete-btn post-delete-btn" data-postid="<?php echo $postData['postID'];?>">Delete Post</span>
                        <?php } ?>    
                    </div>
                    <a>
                        <div class="post-title">
                            <?php echo $postData['title'];?> 
                        </div>
                        <div class="post-description">
                            <?php echo str_replace("\n", "<br>", $postData['description']);?>
                        </div>
                    </a>
                </div>
            </div>
            <div id="writeComment">
                <form>
                    <textarea cols="30" rows="3" name="comment"></textarea>
                    <input type="submit" style="width: 100%" value="send" id="sender">
                </form>
            </div>
            <div id="comments">
                <?php 
                    $stmt = $pdo->prepare("SELECT `username`, `comment`, comments.id as commentID, users.id as userID from `comments` inner join users on users.id = comments.userId where comments.postId=".$_PARAMS['id']);
                    $stmt->execute();
                    while($row = $stmt->fetch()){
                ?>
                    <div class="comment">
                    <img src="<?php echo $ROOT_DIR; ?>/public/svg/person-fill-white.svg" alt="" class="profileImage">
                        <div class="commentBody">
                            <div class="commentAuthor">
                                <?php echo $row['username']; ?>
                                <?php if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $row['userID'])){ ?>
                                    -
                                    <span class="delete-btn comment-delete-btn" data-commentid="<?php echo $row['commentID'];?>">Delete Post</span>
                                <?php } ?>    
                            </div>
                            <div class="commentText">
                                <?php echo str_replace("\n", "<br>", $row['comment']);?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
        <?php if(isset($_SESSION['user'])){ ?>
        $("#sender").addEventListener("click", (e)=>{
            e.preventDefault()
            console.log(e.target.parentNode.comment.value)
            
            let json = new URLSearchParams({
                type: "comment",
                userID:  <?php echo $_SESSION['user']['id']; ?>,
                forumID: <?php echo $postData['forumID']; ?>,
                postID:  <?php echo $_PARAMS['id']; ?>,
                message: encodeURIComponent(e.target.parentNode.comment.value)
            })
            console.log(json);
            handleRequest(e, `${basePath}/api/addData`, json, ()=>window.location.reload())
        })
        <?php } ?>

        deletePostBtn = $$(".post-delete-btn")
        deletePostBtn.forEach(elem =>  {
            elem.addEventListener("click", (e)=>{
                let json = new URLSearchParams({
                    type: "post",
                    id: elem.dataset.postid,
                })
                if(!confirm("Biztos torolni akarod?")) return;
                console.log(json)
                handleRequest(e, `${basePath}/api/removeData`, json, ()=>redirect(basePath+"/"))
            })
        })
        deleteCommentBtn = $$(".comment-delete-btn")
        deleteCommentBtn.forEach(elem =>  {
            elem.addEventListener("click", (e)=>{
                let json = new URLSearchParams({
                    type: "comment",
                    id: elem.dataset.commentid,
                })
                if(!confirm("Biztos torolni akarod?")) return;
                console.log(json)
                handleRequest(e, `${basePath}/api/removeData`, json, ()=>window.location.reload())
            })
        })
    </script>
</body>
</html>