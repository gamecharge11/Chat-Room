<?php  
    session_start();
    if (isset($_COOKIE['uid']) && !isset($_SESSION['logged_in']) || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        ;
    } else {
        header('Location: login.php');
    }
    $con = mysqli_connect("localhost","root","","chat_room");
    $uid = $_GET["id"];
    if (isset($uid)) {
        $queryGet = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$uid'");
        if (mysqli_num_rows($queryGet) > 0) {
            ;
        } else {
            echo "<script>alert('Invalid room ID, please check if the link is right.');location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Room ID not found');location.href='index.php'</script>";
    }

    $rId = $uid;
    $roomRow = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$rId'");
    $roomRow = $roomRow -> fetch_assoc();
    $roomName = $roomRow['name'];
    $members = $roomRow['users'];
    
    $user = $_COOKIE['uid'];
    $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$user'");
    $username = $userRow -> fetch_assoc();
    $username = $username['username'];

    if (strpos($members,$username) !== false) {
        ;
    } else {
        echo "<script>alert('You are not in this room.');location.href='index.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <script src="./js/room.js?<?php echo filemtime('./js/room.js')?>" defer></script>
    <link rel="stylesheet" href="./css/room.css?<?php echo filemtime('./css/room.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="main">
        <nav>
            <h1>Chat Room</h1>
            <div class="group" id="options">
                <button id="invite"><i class="fa-solid fa-user-plus"></i><br>Invite</button>
                <button id="leave"><i class="fa-solid fa-right-from-bracket"></i><br>Leave</button>
            </div>
        </nav>
        <div class="content">
            <div class="overlay hidden" id="overlay">
                <button id="close-overlay"><i class="fa-solid fa-xmark" style="color:red;"></i></button>
                <button id="delete" class="btn"><i class="fa-solid fa-delete-left"></i><br>Delete</button>
                <button id="bookmark" class="btn"><i class="fa-solid fa-bookmark"></i><br>Bookmark</button>
            </div>
            <div class="alert hidden" id="invite-alert">
                <div id="title"></div>
                <div id="description"></div>
                <button id="close">Close</button>
            </div>
            <div class="settings hidden" id="settingsShow">
                <h1 class="title">Settings</h1>
                <button id="close-settings"><i class="fa-solid fa-xmark" style="color:red;"></i></button>
                <div class="group">
                    <div class="wrapper">
                        <div class="section">
                            <h1 class="settings-name">Change Room Name</h1>
                            <input type="text" name="name" id="name" placeholder="Enter a name" autocomplete="off" class="input-settings">
                            <br>
                            <button class="go" id="change">Go</button>
                        </div>
                        <div class="section">
                            <h1 class="settings-name">Transfer Admin</h1>
                            <select name="transfer" id="transfer" class="settings-select select-user">
                                <option value="" disabled selected hidden>Choose a user</option>
                            </select>
                            <br>
                            <button class="go" id="transferAdmin">Go</button>
                        </div>
                        <div class="section" style="background-color:#c72a20;">
                            <h1 class="settings-name">Delete room</h1>
                            <button id="deleteRoom" onclick="deleteRoom()"><i class="fa-solid fa-trash-can"></i><br>Delete Room</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="moderation hidden" id="moderationShow">
                <h1 class="title">Moderation</h1>
                <button id="close-moderation"><i class="fa-solid fa-xmark" style="color:red;"></i></button>
                <div class="group">
                    <div class="wrapper">
                        <div class="section">
                            <h1 class="moderation-name">Mute user</h1>
                            <select name="mute" id="mute" class="moderation-select select-user">
                                <option value="" disabled selected hidden>Choose a user</option>
                            </select>
                            <br>
                            <button class="go" id="muteBtn">Go</button>
                        </div>
                        <div class="section">
                            <h1 class="moderation-name">Unmute user</h1>
                            <select name="unmute" id="unmute" class="moderation-select select-unmute"></select>
                            <br>
                            <button class="go" id="unmuteBtn">Go</button>
                        </div>
                        <div class="section">
                            <h1 class="settings-name">Kick user</h1>
                            <select name="kick" id="kick" class="settings-select select-user">
                                <option value="" disabled selected hidden>Choose a user</option>
                            </select>
                            <br>
                            <button class="go" id="kickBtn">Go</button>
                        </div>
                        <div class="section">
                            <h1 class="settings-name">Ban user</h1>
                            <select name="ban" id="ban" class="settings-select select-user">
                                <option value="" disabled selected hidden>Choose a user</option>
                            </select>
                            <br>
                            <button class="go" id="banBtn">Go</button>
                        </div>
                        <div class="section">
                            <h1 class="settings-name">Unban user</h1>
                            <select name="unban" id="unban" class="settings-select select-banned"></select>
                            <br>
                            <button class="go" id="unbanBtn">Go</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top">
                <h1 class="roomName"><?php echo $roomName; ?></h1>
                <div id="messages">
                    <p class="message">Fetching messages from database...</p>
                </div>
            </div>
            <div class="groupSend">
                <input type="text" name="send" id="send" placeholder="Send a message..." autocomplete="off">
                <button id="sendBtn"><i class="fa fa-paper-plane"></i></button>
            </div>
            <div class="members" id="members">
                <h1 class="member-title">Members</h1>
            </div>
        </div>
    </div>
</body>
</html>