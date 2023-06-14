<?php  
  session_start();
  if (isset($_COOKIE['uid']) && !isset($_SESSION['logged_in']) || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    header("location: index.php");
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat Room</title>
    <script src="./js/signup.js?<?php echo filemtime('./js/signup.js')?>" defer></script>
    <link rel="stylesheet" href="./css/signup.css?<?php echo filemtime('./css/signup.css') ?>" />
  </head>
  <body>
    <nav>
      <h1>Chat Room<span class="nav-location">&nbsp- Signup</span></h1>
    </nav>
    <div class="container">
      <div class="left">
        <canvas id="left-animate"></canvas>
      </div>
      <div class="right">
        <div class="position">
          <form method="post" action="javascript:void(0)" id="form">
            <h1 class="title">Chat Room</h1>
            <input
              type="text"
              name="username"
              placeholder="Username"
              id="username"
              class="input spaced"
              required
            />
            <input
              type="password"
              name="password"
              placeholder="Enter password"
              id="password"
              class="input spaced"
              required
            />
            <div style="display:flex;justify-content:center;align-items:center;flex-direction:row;">
              <input type="checkbox" name="keep_logged" id="keep_logged"> <p style="display: inline;" class="logged">&nbspKeep me logged in</p>
            </div>
            <div class="flex-spacer"></div>
            <input type="submit" value="Create Account" class="btn" />
            <div class="flex-spacer"></div>
            <p>Already have an account? <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
