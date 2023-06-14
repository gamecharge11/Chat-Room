<?php 
  session_start();
  if (isset($_COOKIE['uid']) && !isset($_SESSION['logged_in']) || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    echo(null);
  } else{
    header("location: signup.php");
  }

  $con = mysqli_connect("localhost","root","","chat_room");
  $uid = $_COOKIE['uid'];
  $userRow = mysqli_query($con,"SELECT * FROM users WHERE uid = '$uid'");
  $user = $userRow -> fetch_assoc();
  $username = $user['username'];

  echo "<script>console.log(`Logged in as`,`'".$username."'`);</script>";
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat Room</title>
    <script src="./js/index.js?<?php echo filemtime('./js/index.js')?>" defer></script>
    <link rel="stylesheet" href="./css/style.css?<?php echo filemtime('./css/style.css') ?>" />
  </head>
  <body>
    <nav>
      <h1>Chat Room</h1>
      <button id="settings"><i class="fa-solid fa-gear"></i><br>User Settings</button>
    </nav>
    <div class="body">
      <canvas id="background"></canvas>
      <div class="content">
        <div class="alert hidden" id="success-alert">
          <div id="title">Success!</div>
          <div id="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat necessitatibus delectus, earum repellat sunt modi voluptate atque fugit praesentium odit.</div>
          <button id="close">Close</button>
        </div>
        <div class="bookmark hidden" id="bookmark">
            <h1 class="title">Your bookmarks</h1>
            <button id="closeBookmarks" onclick='document.getElementById("bookmark").classList.add("hidden")'><i class="fa-solid fa-xmark" style="color:red;"></i></button>
            <div class="bookmarks" id="bookmarks"></div>
        </div>
        <div class="panels">
          <div class="left">
            <h1 class="welcome">Welcome, <?php echo $username;?>!</h1>
            <div class="buttons">
              <div class="group">
                <div class="button" id="join"><i class="fa-solid fa-square-plus"></i><p>Join</p></div>
                <div class="button" id="create"><i class="fa-solid fa-comment-medical"></i><p>Create</p></div>
              </div>
              <div class="group">
                <div class="button" id="friends" onclick="openFriends()"><i class="fa-solid fa-users"></i><p>Friends</p></div>
                <div class="button" onclick="openBookmarks()"><i class="fa-solid fa-bookmark"></i><p>Saved</p></div>
              </div>
            </div>
            <div class="friends hidden" id="friendsDiv">
              <p class="title">Friends</p>
              <button id="closeFriends"><i class="fa-solid fa-xmark" style="color: #ff0000;"></i></button>
              <div class="options">
                <div class="option" id="online">
                  <p class="opt">Online</p>
                </div>
                <div class="option" id="all">
                  <p class="opt">All</p>
                </div>
                <div class="option" id="pending">
                  <p class="opt">Pending</p>
                </div>
                <div class="option" id="add">
                  <p class="opt">Add Friend</p>
                </div>
              </div>
              <div id="onlineCont" class="cont">
                <p class="title">Online - <span id="countOnline"></span></p>
                <div class="online" id="online-friends"></div>
              </div>
              <div id="allCont" class="cont hidden">
                <p class="title">All - <span id="countAll"></span></p>
                <div class="all" id="all-friends"></div>
              </div>
              <div id="pendingCont" class="cont hidden">
                <p class="title">Pending - <span id="countPending"></span></p>
                <div class="pending" id="pendingDiv"></div>
              </div>
              <div id="addCont" class="cont hidden">
                <p class="title">Add</p>
                <div class="wrap-add">
                  <input type="text" class="add-friend" id="username-friend" placeholder="Enter the username of the person">
                  <button id="sendRequest"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="right">
            <div id="rooms">
              <h2>Your rooms</h2>
            </div>
          </div>
        </div>
        <div class="alerts" id="alerts"></div>
      </div>
    </div>
  </body>
</html>
