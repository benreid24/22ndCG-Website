<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  $curFile = $_SERVER['REQUEST_URI'];
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("h2ndxygv_Main", $website);
	
	$cmd = $_GET['cmd'];
	$id = $_GET['id'];
?>

<html>
<head>
<title>22nd Century Gaming - Register</title>
<link rel="stylesheet" href="Styles/login.css" type="text/css">
<link rel="stylesheet" href="Styles/styles.css" type="text/css">
<link href="Images/favicon.ico" rel="icon" type="image/bitmap">
</head>
<body>
  <div id="header">
	  <?php
		  include("Util/loginbox.php");
			print LoginBox($curFile);
		?>
	  <a href="index.php"><img src="Images/headimg.png" alt="22nd Century Games" name="22nd Century Games" class="headimg"/></a>
		<br>
		<div id="links">
		  <a href="index.php" class="link">Home</a>
			<a href="games.php" class="link">Games</a>
			<a href="team.php" class="link">The Team</a>
			<a href="contact.php" class="link">Contact us</a>
			<a href="account.php" class="link">My Account</a>
		</div>
	</div>
	
	<div id="content">
	  <h1 id="title">Registration Confirmation</h1>
		<div style="padding-left: 250px;"><div id="registerBox">
		<?php
		  if ($cmd=='c')
			{
			  $id = clean($id);
			  $query = mysql_query("SELECT * FROM Unconfirmed WHERE Id='$id'", $website);
				if ($query)
				{
				  $data = mysql_fetch_array($query);
					$query2 = mysql_query("INSERT INTO Users (Username, Password, Email) VALUES ('".$data['Name']."','".$data['Password']."','".$data['Email']."')", $website);
					mysql_query("DELETE FROM Unconfirmed WHERE Id='$id'", $website);
					print "<p class=\"registerError\">Your account has been activated!</p>";
				}
				else
				print "<p class=\"registerError\">This account has already been taken care of!</p>";
			}
			else if ($cmd=='d')
			{
			  $query = mysql_query("DELETE FROM Unconfirmed WHERE Id='$id'", $website);
				if ($query)
				print "<p class=\"registerError\">Your account has been deleted.</p>";
				else
				print "<p class=\"registerError\">This account has already been deleted!</p>";
			}
			else
			print "<p class=\"registerError\">Why are you here?</p>";
		?>
		</div></div>
  </div>
	
	<br>
	<div id="footer">
	  <?php
		  include("Util/Footer.php");
			print Footer($curFile);
		?>
	</div>
</body>
</html>

