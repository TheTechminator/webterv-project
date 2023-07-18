<?php
    if(isset($_POST['type']))
    switch ($_POST['type']) {
        case 'forum':
            if(empty($_POST["title"]) || empty($_POST["description"])){
                echo '{"type": "fail", "msg":["valamit uresen hagytal"]}'; 
                break;
            }
            $sql = "INSERT INTO `forums` (`creatorId`, `name`, `description`) VALUES ('".$_POST['userID']."', '".urldecode($_POST["title"])."', '".urldecode($_POST["description"])."');";
            $pdo->exec($sql);
            echo '{"type": "success", "msg":["ok"]}'; 
            break;

        case 'post':
            if(empty($_POST["title"]) || empty($_POST["description"])){
                echo '{"type": "fail", "msg":["valamit uresen hagytal"]}'; 
                break;
            }
            $sql = "INSERT INTO `posts` (`forumId`, `userId`, `title`, `description`) VALUES ('".$_POST['forumID']."', '".$_POST['userID']."', '".urldecode($_POST["title"])."', '".urldecode($_POST["description"])."');";
            $pdo->exec($sql);
            echo '{"type": "success", "msg":["ok"]}';
            break;
    
        case 'comment':
            if(empty($_POST["message"])){
                echo '{"type": "fail", "msg":["valamit uresen hagytal"]}'; 
                break;
            }
            $sql = "INSERT INTO `comments` (`userId`, `forumId`, `postId`, `comment`) VALUES ('".$_POST['userID']."', '".$_POST['forumID']."', '".$_POST['postID']."', '".urldecode($_POST["message"])."');";
            $pdo->exec($sql);
            echo '{"type": "success", "msg":["ok"]}';
            break;
            
        default:
            echo "HIBA! ROSSZ AG";
            break;
    }
?>