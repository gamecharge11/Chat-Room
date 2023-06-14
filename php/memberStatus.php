<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $members = $_POST['members'];
    $mList = json_decode($members);

    $final = "[";
    for ($i = 0;$i < count($mList);$i++) {
        $current = $mList[$i];
        $userRow = mysqli_query($con,"SELECT * FROM users WHERE username = '$current'");
        $status = $userRow -> fetch_assoc();
        $status = $status['online'];
        if ($i != count($mList)-1) {
            $final .= '["'.$current.'","'.$status.'"],';
        } else {
            $final .= '["'.$current.'","'.$status.'"]]';
        }
    }
    echo $final;
?>