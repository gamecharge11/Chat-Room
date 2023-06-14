<?php 
    $con = mysqli_connect("localhost","root","","chat_room");
    $rId = $_POST['rId'];
    $roomRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $messages = $roomRow -> fetch_assoc();
    $messages = $messages['messages'];
    echo $messages;
?>