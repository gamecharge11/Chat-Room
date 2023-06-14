<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $rId = $_POST['rId'];

    $roomRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    if ($roomRow) {
        $members = $roomRow -> fetch_assoc();
        $members = $members['users'];
        echo "++" . $members;
    } else {
        echo 0;
    }
?>