<?php
    include("Util/Clean.php");
	include("Util/Config.php");
    $error = $_GET['e'];
	if (!isset($error))
    $error = "none";
    $command = $_POST['cmd'];
    $name = $_POST['name'];
    $pw = $_POST['pw'];
    $referer = $_GET['referer'];
	if (!isset($referer))
	  $referer = $_POST['referer'];
	if (!isset($referer))
	  $referer = "http://www.22ndcg.org/login.php";
  
    if (!strpos($referer,"22ndcg."))
		$referer = "http://22ndcg.org".$referer;
	
	print("Referred by: ".$referer);
	
    session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("h2ndxygv_Main", $website);
	
	if ($command=="Login")
	{
	    $name = clean($name);
	    $query = mysql_query("SELECT * FROM Users WHERE Username='$name'", $website);
	    $tmp = mysql_fetch_array($query);
	    $query = mysql_query("SELECT * FROM Admins WHERE Username='$name'", $website);
	    $admin = mysql_fetch_array($query);
	    $_SESSION['admin'] = false;
		
		if ($tmp)
		{
			if (crypt($pw,$tmp['Password'])==$tmp['Password'])
			{
				$_SESSION['name'] = $name;
				Header("Location: $referer");
			}
			else if (!$admin)
				$error = "Invalid username/password!";
		}
		if ($admin)
		{
			if (crypt($pw,$admin['Password'])==$admin['Password'])
			{
				$_SESSION['name'] = $name;
				$_SESSION['admin'] = true;
				Header("Location: $referer");
			}
			else
				$error = "Invalid username/password!";
		}
		else if (!$tmp)
			$error = "Invalid username/password!";
	}
	else if ($command=="Logout")
	{
	    $_SESSION['name'] = "out";
		$_SESSION['admin'] = false;
		$error = "You have been successfully logged out.";
		$referer = "http://www.22ndcg.org/login.php";
	}
?>	

<html>
<head>
  <title>22nd Century Games - Login</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="Styles/login.css" rel="stylesheet" type="text/css">
	<link href="Images/favicon.ico" rel="icon" type="image/bitmap">
</head>
<body>
  <div id="header">
	  <?php
	      $referer = str_replace("http://22ndcg.org","",$referer);
		  include("Util/loginbox.php");
			print LoginBox($referer);
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
	  <?php
			if ($error!="none")
	      print "<p class=\"error\">$error</p>";
			else
			  print "<p class=\"error\">You have been successfully logged in.</p>";
			if (!$_SESSION['name'] || $_SESSION['name']=="out")
			{
			  print "<form action=\"login.php\" method=\"post\">";
				print "<input type=\"hidden\" name=\"referer\" value=\"$referer\"/>";
				print "Username: <input type=\"text\" name=\"name\" size=\"25\"/><br>";
				print "Password: <input type=\"password\" name=\"pw\" size=\"25\"/><br>";
				print "<input type=\"submit\" name=\"cmd\" value=\"Login\"/>";
				print "</form>";
			}
			else
			{
			  print "Logged in as <a href=\"account.php\"><span class=\"error\">".$_SESSION['name']."</span></a><br>";
				print "<form action=\"login.php\" method=\"post\">";
				print "<input name=\"cmd\" value=\"Logout\" type=\"submit\"/>";
				print "</form>";
		  }
		?>
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
