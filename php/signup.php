<?php
    $con = mysqli_connect("localhost","root","","chat_room");
    session_start();

    $user = $_POST['username'];
    $password = $_POST['password'];
    $logged = $_POST['keep_logged'];
    $id = uniqid();

    $taken = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE username = '$user'"));
    
    if ($taken > 0) {
        echo 2;
    } else {
        $sql = "INSERT INTO users (username,password,online,bookmarked,pending,friends,uid) VALUES('$user','$password','false','[]','[]','[]','$id')";
        $execute = mysqli_query($con,$sql);
        if ($execute) {
            setcookie('uid',$id,time()+(86400*30),"/");
            if ($logged == "true") {
                setcookie('logged_in',"1",time()+(86400*30),"/"); // 86400 * 30 = 30 days
            } else {
                $_SESSION['temp_logged'] = "1";
            }
            echo 1;
        } else {
            echo 0;
        }
    }
?>
