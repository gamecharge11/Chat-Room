<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $rId = $_POST['rId'];

    $room = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $muted = $room -> fetch_assoc();
    $muted = $muted['muted'];

    echo $muted;
?>