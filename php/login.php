<?php
    $con = mysqli_connect("localhost","root","","chat_room");
    session_start();

    $user = $_POST['username'];
    $password = $_POST['password'];
    $logged = $_POST['keep_logged'];

    $taken = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE username = '$user'"));

    if ($taken > 0) {
        $execute = mysqli_query($con,"SELECT * FROM users WHERE username = '$user'");
        $row = $execute -> fetch_assoc();
        $id = $row['uid'];
        if ($execute) {
            setcookie('uid',$id,time()+(86400*30),"/");
            if ($logged == "true") {
                setcookie('logged_in',"1",time()+(86400*30),"/"); // 86400 * 30 = 30 days
                echo 1;
            } else {
                $_SESSION['temp_logged'] = "1";
                echo 1;
            }
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
?>
