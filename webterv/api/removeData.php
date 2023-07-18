<?php
    if(isset($_POST['type']))
    switch ($_POST['type']) {
        case 'forum':
            $stmt = $pdo->prepare("SELECT * FROM `forums` where forums.id=".$_POST['id']);
            $stmt->execute();
            $res = $stmt->fetch();
            if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $res['creatorId'])){
                $stmt = $pdo->prepare("DELETE FROM `forums` where forums.id=".$_POST['id']);
                $stmt->execute();
                echo '{"type": "success", "msg":["ok"]}';
            }
            break;
        
        case 'post':
            $stmt = $pdo->prepare("SELECT * FROM `posts` where posts.id=".$_POST['id']);
            $stmt->execute();
            $res = $stmt->fetch();
            if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $res['userId'])){
                $stmt = $pdo->prepare("DELETE FROM `posts` where posts.id=".$_POST['id']);
                $stmt->execute();
                echo '{"type": "success", "msg":["ok"]}';
            }
            break;
        
        case 'comment':
            $stmt = $pdo->prepare("SELECT * FROM `comments` where comments.id=".$_POST['id']);
            $stmt->execute();
            $res = $stmt->fetch();
            if(isset($_SESSION['user']) && (in_array($_SESSION['user']['type'], ["admin", "moderator"]) || $_SESSION['user']['id'] == $res['userId'])){
                $stmt = $pdo->prepare("DELETE FROM `comments` where comments.id=".$_POST['id']);
                $stmt->execute();
                echo '{"type": "success", "msg":["ok"]}';
            }
            break;
        
        default:
            # code...
            break;
    }
?>