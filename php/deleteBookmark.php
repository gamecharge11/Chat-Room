<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $id = $_POST['id'];

    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $bookmarks = $userRow -> fetch_assoc();
    $bookmarks = $bookmarks["bookmarked"];
    $bookmarks = json_decode($bookmarks,true);

    for ($i = 0;$i < count($bookmarks);$i++) {
        if ($bookmarks[$i]["id"] == $id) {
            unset($bookmarks[$i]);
        }
    }

    $bookmarks = array_values($bookmarks);
    $bookmarks = json_encode($bookmarks);

    $update = mysqli_query($con,"UPDATE users SET bookmarked = '$bookmarks' WHERE uid = '$uid'");
    if ($update) {
        echo 1;
    } else {
        echo 0;
    }
?>