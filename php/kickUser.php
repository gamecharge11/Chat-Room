<?php 
    error_reporting(E_ERROR | E_PARSE);
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
        if ($rAdm != $name) {
            $members = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
            $members = $members -> fetch_assoc();
            $members = $members['users'];
            $members = explode(",",$members);

            if (end($members) == "") {
                array_pop($members);
            } 

            for ($x = 0;$x < count($members);$x++) {
                if ($members[$x] == $name) {
                    unset($members[$x]);
                    break;
                }
            }

            $joined = join(",",$members);
            $updateQuery = mysqli_query($con,"UPDATE rooms SET users = '$joined' WHERE uid = '$rId'");
            if ($updateQuery) {
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