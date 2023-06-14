<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $rId = $_POST['rId'];
    $name = $_POST['user'];

    $username = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $username -> fetch_assoc();
    $username = $username['username'];

    $rAdm = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $rAdm = $rAdm -> fetch_assoc();
    $rAdm = $rAdm['admin'];

    if ($username == $rAdm) {
        $rRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
        $muted = $rRow -> fetch_assoc();
        $muted = $muted['muted'];
        $muted = json_decode($muted);

        if (in_array($name,$muted)) {
            $room = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
            $muted = $room -> fetch_assoc();
            $muted = $muted['muted'];
            $muted = json_decode($muted);

            for ($i = 0; $i < count($muted);$i++) {
                if ($muted[$i] == $name) {
                    unset($muted[$i]);
                }
            }
            $muted = json_encode(array_values($muted));

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
        echo 2;
    }
?>