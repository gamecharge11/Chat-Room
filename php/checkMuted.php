<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];

    $username = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $username -> fetch_assoc();
    $username = $username['username'];

    $rRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $muted = $rRow -> fetch_assoc();
    $muted = $muted['muted'];
    $muted = json_decode($muted);

    if (in_array($username,$muted)) {
        echo 1;
    } else {
        echo 0;
    }
?>