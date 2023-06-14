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
        if ($name != $rAdm) {
            // ? Adding users name to banned list
            $currentBanned = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
            $currentBanned = $currentBanned -> fetch_assoc();
            $currentBanned = $currentBanned['banned'];
            $currentBanned = json_decode($currentBanned);

            array_push($currentBanned,$name);
            $newBanned = json_encode(array_values($currentBanned));
            $update = mysqli_query($con,"UPDATE rooms SET banned = '$newBanned' WHERE uid = '$rId'");
            if ($update) {
                // ? Removing user from room
                $members = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
                $members = $members -> fetch_assoc();
                $members = $members['users'];
                $members = explode(",",$members);

                if (end($members) == "") {
                    array_pop($members);
                }
                
                for ($x = 0; $x < count($members);$x++) {
                    if ($members[$x] == $name) {
                        unset($members[$x]);
                        break;
                    }
                }

                $membersNew = join(",",array_values($members));
                $updateMembers = mysqli_query($con,"UPDATE rooms SET users = '$membersNew' WHERE uid = '$rId'");
                if ($updateMembers) {
                    echo 1;
                } else {
                    echo 0;
                }
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