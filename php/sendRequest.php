<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $name = $_POST['user'];
    $senderUid = mysqli_query($con,"SELECT * FROM users WHERE username = '$name'");
    
    if (mysqli_num_rows($senderUid) > 0) {
        $id = $senderUid -> fetch_assoc();
        $id = $id['uid'];

        $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
        $username = $userRow -> fetch_assoc();
        $username = $username['username'];

        $toSend = mysqli_query($con,"SELECT * FROM users WHERE username = '$name'");
        $toSend = $toSend -> fetch_assoc();
        $friendsToSend = $toSend['friends'];
        $friendsToSend = json_decode($friendsToSend);
        $isFriended = FALSE;

        for ($i = 0;$i < count($friendsToSend);$i++) {
            if ($friendsToSend[$i] == $username) {
                $isFriended = TRUE;
            }
        }

        if (!$isFriended) {
            $sendRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$id'");
            $pending = $sendRow -> fetch_assoc();
            $pending = $pending['pending'];
            $pending = json_decode($pending);

            array_push($pending,$username);

            $pending = json_encode(array_values($pending));
            $update = mysqli_query($con,"UPDATE users SET pending = '$pending' WHERE uid = '$id'");
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