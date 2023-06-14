<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];
    
    $banned = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $banned = $banned -> fetch_assoc();
    $banned = $banned['banned'];

    echo $banned;
?>