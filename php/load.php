<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $uRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $uRow = $uRow -> fetch_assoc();
    $status = $uRow['online'];
    if ($status == "false") {
        $query = mysqli_query($con,"UPDATE users SET online = 'true' WHERE uid = '$uid'");
        if ($query) {
            echo 1;
        }else{
            echo 0;
        }
    }
?>