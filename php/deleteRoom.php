<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];

    $rAdm = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $rAdm = $rAdm -> fetch_assoc();
    $rAdm = $rAdm['admin'];

    $username = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $username -> fetch_assoc();
    $username = $username['username'];

    if ($rAdm == $username) {
        $delete = mysqli_query($con,"DELETE FROM rooms WHERE uid = '$rId'");
        if ($delete) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
?>