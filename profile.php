<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

include 'verifyPanel.php';
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Panel - Profile</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>

<?php
include 'header/header.php';
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Profile Menu</h1>
		  <p class="page-header">Allows you to edit your account.</p>

<?php

if (isset($_POST['updateButton'])) {
    $fail = false;

    if ($_POST['curPass'] != '') {
        $curPass = $_POST['curPass'];
        $curPass = sha1($curPass);
    } else {
        $fail = true;
    }

    if ($_POST['pass'] != '') {
        $pass = $_POST['pass'];
    } else {
        $fail = true;
    }

    if ($_POST['pass1'] != '') {
        $pass1 = $_POST['pass1'];
    } else {
        $fail = true;
    }
    if ($fail === false) {
        loginconnect();

        $SelectQ = "SELECT * FROM users WHERE username = '$user'";
        $result = mysqli_query($dbconL, $SelectQ);
        $dbPass = $result->fetch_object();
        $passR = $dbPass->password;

        if ($passR == $curPass) {
            if ($pass == $pass1) {
                //same

        echo '<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Password changed.</a></div>';

                $pass = sha1($pass);

                $UpdateQ = "UPDATE users SET password='$pass' WHERE username='$user'";
                mysqli_query($dbconL, $UpdateQ);
            } else {
                //not same

          echo '<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">Passwords do not match!</a></div>';
            }
        } else {
            echo'<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">Current password is wrong!</a></div>';
        }
    } else {
        echo'<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">Please fill both boxes!</a></div>';
    }
}//end of update
?>

<div class='panel panel-info'>
<div class='panel-heading'>
<h3 class='panel-title'>User Info</h3>
</div>
<div class='panel-body'>
<center><h4><?php echo $user; ?></h4>
<br>

<center><img alt="User Pic" src="images/man.png" class="img-circle img-responsive" width="150" height="150">

<br>

<form action = "profile.php" method="post">
<h4>Current Password</h4>
<input type="password" name= "curPass" class="form-control" value="" placeholder="Current Password...">
<h4>Password</h4>
<input type="password" name= "pass" class="form-control" value="" placeholder="Password...">

<h4>Repeat Password</h4>
<input type="password" name= "pass1" class="form-control" value="" placeholder="Repeat password...">

<br>
<button type="submit" name="updateButton" class="btn btn-primary btn-lg btn-block btn-outline">Update</button>
</form>

</div>
</div>

          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
