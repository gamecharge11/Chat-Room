<?php 
    error_reporting(E_ERROR | E_PARSE);
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];
    
    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $userRow -> fetch_assoc();
    $username = $username['username'];

    $members = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $members = $members -> fetch_assoc();
    $members = $members['users'];
    $members = explode(",",$members);

    if (end($members) == "") {
        array_pop($members);
    } 
    
    for ($x = 0;$x < count($members);$x++) {
        if ($members[$x] == $username) {
            unset($members[$x]);
            break;
        }
    }

    $joined = join(",",$members);
    $updateQuery = mysqli_query($con,"UPDATE rooms SET users = '$joined' WHERE uid = '$rId'");

    echo 1;
?>