<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $name = $_POST['user'];

    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $pending = $userRow -> fetch_assoc();
    $pending = $pending['pending'];
    $pending = json_decode($pending);

    $username = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $username -> fetch_assoc();
    $username = $username['username'];

    if (in_array($name,$pending)) {
        for ($x = 0;$x < count($pending);$x++) {
            if ($pending[$x] == $name) {
                unset($pending[$x]);
                break;
            }
        }

        $newPending = json_encode(array_values($pending));
        $update = mysqli_query($con, "UPDATE users SET pending = '$newPending' WHERE uid = '$uid'");

        $sentRow = mysqli_query($con,"SELECT * FROM users WHERE username = '$name'");
        $sentPending = $sentRow -> fetch_assoc();
        $sentPending = $sentPending['pending'];
        $sentPending = json_decode($sentPending);

        for ($x = 0;$x < count($sentPending);$x++) {
            if ($sentPending[$x] == $name) {
                unset($sentPending[$x]);
                break;
            }
        }

        $newSentPending = json_encode(array_values($sentPending));
        $sentUpdate = mysqli_query($con, "UPDATE users SET pending = '$newSentPending' WHERE username = '$name'");
        
        if ($update && $sentUpdate) {
            $friends = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
            $friends = $friends -> fetch_assoc();
            $friends = $friends['friends'];
            $friends = json_decode($friends);

            array_push($friends,$name);
            $newFriends = json_encode(array_values($friends));
            $updateFriends = mysqli_query($con,"UPDATE users SET friends = '$newFriends' WHERE uid = '$uid'");

            $sentFriends = mysqli_query($con,"SELECT * FROM users WHERE username = '$name'");
            $sentFriends = $sentFriends -> fetch_assoc();
            $sentFriends = $sentFriends['friends'];
            $sentFriends = json_decode($sentFriends);

            array_push($sentFriends,$username);
            $newSentFriends = json_encode(array_values($sentFriends));
            $updateSentFriends = mysqli_query($con,"UPDATE users SET friends = '$newSentFriends' WHERE username = '$name'");

            if ($updateFriends && $updateSentFriends) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }

    } else {
        echo 2;
    }
?>