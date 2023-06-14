<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $message = $_POST['message'];
    $rId = $_POST['rId'];
    $time = $_POST['time'];
    $uid = $_COOKIE['uid'];
    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $username = $userRow -> fetch_assoc();
    $username = $username['username'];

    $room = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $muted = $room -> fetch_assoc();
    $muted = $muted['muted'];
    $muted = json_decode($muted);
    
    if (!in_array($username,$muted)) {
        $sendJson = array("sender"=>$username,"content"=>$message,"id"=>uniqid(), "time"=>$time);
        $sendJson = json_encode($sendJson);
        
        $currentRoom = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
        $msgs = $currentRoom -> fetch_assoc();
        $msgs = $msgs['messages'];
        $msgs = substr($msgs,0,-1);
        if ($msgs != "[") {
            $msgs = $msgs . "," . $sendJson . "]";
        } else {
            $msgs = $msgs . $sendJson . "]";
        }

        $update = mysqli_query($con,"UPDATE rooms SET messages = '$msgs' WHERE uid = '$rId'");
        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
?>