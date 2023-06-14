<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    
    $user = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $user = $user -> fetch_assoc();
    $user = $user['username'];

    echo $user;
?>