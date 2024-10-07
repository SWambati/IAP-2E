<?php
require "constants.php";
require "dbconn.php";
$conn = new dbConn(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css">
        <title>Sign Up</title>
    </head>
    <body>
        <div class="signup-container">
            <form action="signup2.php" method="POST">
              <h1>Sign Up</h1>
                <div class="input">
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email address" name="email" required>
                  <i class="fa fa-user"></i>
                </div>
                <div class="input">
                  
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="password"name="password" required>
                  <i class="fa fa-lock"></i>
                </div>
                <div class="input">
                 
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm password" name="confirm_password" required>
                  <i class="fa fa-lock"></i>
                </div>
                <div class="remember-me">
                  <label><input type="checkbox">Remember me</label>
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
              </form>

        </div>
    </body>
</html>