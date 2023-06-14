<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_COOKIE['uid'];
    $roomId = $_POST['id'];
    $cQuery = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$roomId'");
    $uQuery = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
    $uQuery = $uQuery -> fetch_assoc();
    $user = $uQuery['username'];
    if (mysqli_num_rows($cQuery) > 0) {
        $banned = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$roomId'");
        $banned = $banned -> fetch_assoc();
        $banned = $banned['banned'];
        $banned = json_decode($banned);

        if (!in_array($user,$banned)) {
            $assoc = $cQuery -> fetch_assoc();
            $a = $assoc["users"];
            $uArr = explode(",",$a);

            if (end($uArr) == "") {
                array_pop($uArr);
            }

            if (!in_array($user,$uArr)) {
                array_push($uArr,$user);
                $str = "";
                for ($i = 0;$i < count($uArr);$i++) {
                    $str .= $uArr[$i].",";
                }
                $update = mysqli_query($con,"UPDATE rooms SET users = '$str' WHERE uid = '$roomId'");

                if ($update) {
                    echo "1";
                } else {
                    echo "3";
                }
            } else {
                echo "4";
            }
        } else {
            echo "5";
        }
    } else {
        echo "2";
    }
?>