<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $id = $_POST['id'];
    $rId = $_POST['rId'];
    $user = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $user = $user -> fetch_assoc();
    $user = $user['username'];

    $roomRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $roomMsg = $roomRow -> fetch_assoc();
    $messages = $roomMsg['messages'];
    $messages = json_decode($messages,true);
    
    for ($i = 0;$i < count($messages);$i++) {
        $current = $messages[$i];
        if ($current['id'] == $id && $current['sender'] == $user) {
            unset($messages[$i]);
        }
    }

    $messages = array_values($messages);
    $msgString = json_encode($messages);
    $update = mysqli_query($con,"UPDATE rooms SET messages = '$msgString' WHERE uid = '$rId'");
    if ($update) {
        echo 1;
    } else {
        echo 0;
    }
?>