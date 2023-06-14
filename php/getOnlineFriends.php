<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE["uid"];
    $t = "true";
    
    $friends = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $friends = $friends -> fetch_assoc();
    $friends = $friends['friends'];
    $friends = json_decode($friends);

    $onlineFriends = array();

    for ($x = 0;$x < count($friends);$x++) {
        $current = $friends[$x];
        $friend = mysqli_query($con,"SELECT * FROM users WHERE username = '$current'");
        $online = $friend -> fetch_assoc();
        $online = $online['online'];

        if ($online == 'true') {
            array_push($onlineFriends,$current);
        }
    }

    $onlineFriends = json_encode(array_values($onlineFriends));
    echo $onlineFriends;
?>