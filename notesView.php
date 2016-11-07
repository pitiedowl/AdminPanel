<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

if ($staffPerms['notes'] != '1') {
    header('Location: lvlError.php');
}

include 'verifyPanel.php';
masterconnect();
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

    <title>Admin Panel - Notes View</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

<?php

if (isset($_POST['search'])) {
    $valuetosearch = $_POST['SearchValue'];
    $sqlget = "SELECT * FROM notes WHERE CONCAT (`name`) LIKE '%".$valuetosearch."%' ORDER BY note_id DESC";
    $search_result = filterTable($dbcon, $sqlget);
} else {
    $sqlget = 'SELECT * FROM notes ORDER BY note_id DESC';
    $search_result = filterTable($dbcon, $sqlget);
}

include 'header/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">Notes View</h1>
<p class="page-header">Notes View, Allows you too see all of the notes set.</p>

<div class="btn-group" role="group" aria-label="...">
<FORM METHOD="LINK" ACTION="players.php">
<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
</FORM>
</div>


<form action = "notesView.php" method="post">
		  <div class ="searchBar">
			<div class="row">
			  <div class="col-lg-6">
				<div class="input-group">
				  <input type="text" class="form-control" style = "width: 300px; " name="SearchValue" placeholder="Player name...">
				  <span class="input-group-btn">
					<input class="btn btn-default"  name="search" type="submit" value="Search">
				  </span>
				</div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
		  </div>
</form>

			<br>


          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Player Warned</th>
					<th>Player Alias</th>
                    <th>Player Note</th>
                    <th>Staff Member</th>
					<th>Timestamp</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<form action=notesView.php method=post>';
    echo '<tr>';

    if ($row['warning'] == 2) {
        echo '<td style=background-color:#FFA500;>'.$row['name'].' </td>';
        echo '<td style=background-color:#FFA500;>'.$row['alias'].' </td>';
        echo '<td style=background-color:#FFA500;>'.$row['note_text'].' </td>';
        echo '<td style=background-color:#FFA500;>'.$row['staff_name'].' </td>';
        echo '<td style=background-color:#FFA500;>'.$row['note_updated'].' </td>';
    } elseif ($row['warning'] == 3) {
        echo '<td style=background-color:#FF0000;>'.$row['name'].' </td>';
        echo '<td style=background-color:#FF0000;>'.$row['alias'].' </td>';
        echo '<td style=background-color:#FF0000;>'.$row['note_text'].' </td>';
        echo '<td style=background-color:#FF0000;>'.$row['staff_name'].' </td>';
        echo '<td style=background-color:#FF0000;>'.$row['note_updated'].' </td>';
    } else {
        echo '<td>'.$row['name'].' </td>';
        echo '<td>'.$row['alias'].' </td>';
        echo '<td>'.$row['note_text'].' </td>';
        echo '<td>'.$row['staff_name'].' </td>';
        echo '<td>'.$row['note_updated'].' </td>';
    }

    echo '</tr>';
    echo '</form>';
}

echo '</table></div>';
?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>