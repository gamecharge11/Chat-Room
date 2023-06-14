<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    
    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $pending = $userRow -> fetch_assoc();
    $pending = $pending['pending'];

    echo $pending;
?>