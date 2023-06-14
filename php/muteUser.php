<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];
    $user = $_POST['user'];
    
    $rRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $rAdm = $rRow -> fetch_assoc();
    $rAdm = $rAdm['admin'];

    $username = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $username -> fetch_assoc();
    $username = $username['username'];

    if ($rAdm == $username) {
        if ($user != $rAdm) {
            $room = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
            $muted = $room -> fetch_assoc();
            $muted = $muted['muted'];
            $muted = json_decode($muted);
            if (!in_array($user,$muted)) {
                array_push($muted,$user);
                $muted = json_encode($muted);
                $update = mysqli_query($con,"UPDATE rooms SET muted = '$muted' WHERE uid = '$rId'");
                if ($update) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 3;
            }
        } else {
            echo 4;
        }
    } else {
        echo 2;
    }
?>