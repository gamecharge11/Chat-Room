<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];
    $name = $_POST['user'];
    
    $rAdm = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $rAdm = $rAdm -> fetch_assoc();
    $rAdm = $rAdm['admin'];

    $username = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $username -> fetch_assoc();
    $username = $username['username'];

    if ($rAdm == $username) {
        $banned = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
        $banned = $banned -> fetch_assoc();
        $banned = $banned['banned'];
        $banned = json_decode($banned);

        for ($x = 0;$x < count($banned);$x++) {
            if ($banned[$x] == $name) {
                unset($banned[$x]);
            }
        }

        $banned = json_encode(array_values($banned));
        $update = mysqli_query($con,"UPDATE rooms SET banned = '$banned' WHERE uid = '$rId'");
        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
?>