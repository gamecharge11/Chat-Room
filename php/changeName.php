<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];
    $name = $_POST['name'];

    // ? Checking if account that sent request is admin

    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $userRow -> fetch_assoc();
    $username = $username['username'];

    $rAdm = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $rAdm = $rAdm -> fetch_assoc();
    $rAdm = $rAdm['admin'];

    if ($rAdm == $username) {
        $update = mysqli_query($con,"UPDATE rooms SET name = '$name' WHERE uid = '$rId'");
        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
?>