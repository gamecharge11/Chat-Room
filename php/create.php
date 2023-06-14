<?php 
    error_reporting(E_ERROR | E_PARSE);
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE["uid"];
    $name = $_POST['name'];

    // ? Fetch information of admin user by uid

    $adminRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $adminUserF = $adminRow -> fetch_assoc();
    $adminUser = $adminUserF['username'];
    $uidR = uniqid();
    $updateRooms = mysqli_query($con,"INSERT INTO rooms (name,admin,users,messages,muted,banned,uid) VALUES('$name','$adminUser','$adminUser', '[]','[]','[]', '$uidR')");

    if ($updateRooms) {
        echo $uidR;
    } else {
        echo "Error";
    }
?>