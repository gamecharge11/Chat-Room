<!DOCTYPE html>
<html lang="en">
   <head>
      <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
      ></script>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Invite template</title>
      <link rel="stylesheet" href="./css/invite.css">
   </head>
   <body>
      <nav>
         <h1>Chat Room</h1>
      </nav>
      <div class="container">
         <div class="inv-cont">
            <h1 class="title">You have an invite from <?php 
               $con = mysqli_connect("localhost","root","","chat_room");
               $uid = $_GET["id"];
               if (isset($uid)) {
                  $queryGet = mysqli_query($con,"SELECT * FROM rooms WHERE uid = '$uid'");
                  if (mysqli_num_rows($queryGet) > 0) {
                     $assoc = $queryGet -> fetch_assoc();
                     echo $assoc["admin"];
                  } else {
                     echo "<script>alert('Invalid room ID, please check if the link is right.');location.href='login.php';</script>";
                  }
               } else {
                  echo "<script>alert('Room id not found in link, please check if the link is right.');location.href='login.php';</script>";
               }
            ?>!</h1>
            <button class="btn" id="join">Join chat room</button>
         </div>
      </div>
      <script>
      document.getElementById("join").addEventListener("click", function () {
         let id = new URLSearchParams(document.location.search);
         id = id.get("id")
         let form = document.createElement("form");
         let data = new FormData(form);
         data.append("id", id);
         $.ajax({
            url: "./php/join.php",
            type: "POST",
            data: data,
            success: function (response) {
               if (response == 1) {
                  location.href = `room.php?id=${id}`;
               } else if (response == 2) {
                  alert("Room ID not found")
               } else if (response == 3) {
                  notify("error", "Error", "A database error occured");
               } else if (response == 4) {
                  location.href = `room.php?id=${id}`;
               } else {
                  alert("An unknown error occured: \n\n" + response)
               }
            },
            cache: false,
            contentType: false,
            processData: false,
         });
      });
      </script>
   </body>
</html>