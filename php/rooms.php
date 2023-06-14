<?php
$con = mysqli_connect("localhost","root","","chat_room");
$uid = $_COOKIE['uid'];
$userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
$user = $userRow -> fetch_assoc();
$username = $user['username'];

$rooms = mysqli_query($con, "SELECT * FROM rooms");
$rows = array();
while ($row = mysqli_fetch_assoc($rooms)) { 
    $rows[] = $row;
} 

$rooms = array();
foreach($rows as $row) {
    $members = $row['users'];
    $members = explode(",",$members);
    
    if (end($members) == "") {
      array_pop($members);
    }

    if (in_array($username,$members)) {
      $rooms[] = array($row['name'],$row['uid']);
    }
}
echo json_encode($rooms);

?>