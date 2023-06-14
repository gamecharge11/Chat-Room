<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $id = $_POST['id'];
    $rId = $_POST['rId'];
    $sender = $_POST['sender'];
    $content = $_POST['content'];
    $time = $_POST['time'];

    // ? Checking if message is already bookmarked
    
    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $bookmarks = $userRow -> fetch_assoc();
    $bookmarks = $bookmarks["bookmarked"];
    $bookmarks = json_decode($bookmarks,true);
    $bookmarkExists = FALSE;

    for ($i = 0;$i < count($bookmarks);$i++) {
        if ($bookmarks[$i]["id"] == $id) {
            $bookmarkExists = TRUE;
            echo 2;
        }
    }

    // ? Adding bookmark
    if (!$bookmarkExists) {
        for ($i = 0;$i < count($bookmarks);$i++) {
            if ($bookmarks[$i]["id"] == $id) {
                unset($bookmarks[$i]);
            }
        }
        
        $toAdd = array("id"=>$id,"rId"=>$rId,"sender"=>$sender,"content"=>$content,"time"=>$time);
        $toAdd = json_encode($toAdd);
        
        $current = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
        $bookmarks = $current -> fetch_assoc();
        $bookmarks = $bookmarks['bookmarked'];
        $bookmarks = substr($bookmarks,0,-1);
        if ($bookmarks != "[") {
            $bookmarks = $bookmarks . "," . $toAdd . "]";
        } else {
            $bookmarks = $bookmarks . $toAdd . "]";
        }

        $update = mysqli_query($con,"UPDATE users SET bookmarked = '$bookmarks' WHERE uid = '$uid'");
        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    }
?>