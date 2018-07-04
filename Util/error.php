<?php
  session_start();
  include("Config.php");
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("hqlkiaju_Main", $website);
	
	$done = $_POST['done'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$issue = $_POST['issue'];
	$page = $_POST['ref'];
	if (!$page)
	$page = $_GET['ref'];
	if (!$page)
	Header("Location: http://www.22ndcg.com/");
	
  if ($_SESSION['name'] && $_SESSION['name']!="out")
	{
	  $name = $_SESSION['name'];
		$query = mysql_query("SELECT * FROM Users WHERE Username='$name'", $users);
		$data = mysql_fetch_array($query);
		$email = $data[3];
	}
	
	$curFile = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="../Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="../Styles/admin.css" rel="stylesheet" type="text/css">
	<link href="../Images/favicon.ico" rel="icon" type="image/bitmap">
</head>

<body> 
  <div id="header">
	  <?php
		  include("loginbox.php");
			print LoginBox($curFile);
		?>
	  <a href="../index.php"><img src="../Images/headimg.png" alt="22nd Century Games" name="22nd Century Games" class="headimg"/></a>
		<br>
		<div id="links">
		  <a href="../index.php" class="link">Home</a>
			<a href="../games.php" class="link">Games</a>
			<a href="../team.php" class="link">The Team</a>
			<a href="../contact.php" class="link">Contact us</a>
			<a href="../account.php" class="link">My Account</a>
		</div>
	</div>
	
	<div id="content">
	  <h1 id="title">Error Report</h1>
		<p id="siteDesc">Spotted an error on one of our pages? Tell us about it here.</p>
		<?php
		  if ($done)
			{
			  $to = "feedback@22ndcg.com";
				$subject = "Error reported for: $page";
				$message = "An error has been reported by $name ($email) on $page\r\n\r\n";
				$message .= "$issue";
				$headers = "From: admin@22ndcg.com";
				mail($to, $subject, $message, $headers);
				print "<div style=\"padding-left: 150px;\"><p class=\"success\">Your error has been reported.<br>Thankyou for your time!</p></div>";
			}
			else
			{
			  print "<form action=\"error.php\" method=\"post\" class=\"adForm\">";
				print "<input type=\"hidden\" name=\"ref\" value=\"$page\"/>";
				print "Name: <input type=\"text\" name=\"name\" value=\"$name\" required=\"required\" size=\"30\"/><br>";
				print "Email: <input type=\"text\" name=\"email\" value=\"$email\" required=\"required\" size=\"40\"/><br>";
				print "Issue:<br><textarea name=\"issue\" cols=\"45\" rows=\"15\"></textarea><br>";
				print "<input type=\"submit\" name=\"done\" value=\"Submit\"/>";
				print "</form>";
			}
		?>
  </div>
	
	<br>
	<div id="footer">
	  <?php
		  include("Footer.php");
			print Footer($curFile);
		?>
	</div>
</body>
</html>