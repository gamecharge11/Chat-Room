<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];

    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $userRow = $userRow -> fetch_assoc();
    $bookmarked = $userRow['bookmarked'];

    echo $bookmarked;
?>