<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("h2ndxygv_Main", $website);
	$curFile = $_SERVER['REQUEST_URI'];
	
	$step = $_POST['step'];
	if (!isset($step))
	$step = 1;
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
	  <h1 id="title">Register</h1>
		<p id="siteDesc">Why register? Good question<br>Simply put, some of our games have online features such as multiplayer, if you wish to use these features, you must
		have an account you can login with. You also must have
		an account to leave feedback for games or to post in their forums.</p>
		<div style="padding-left: 250px;"><div id="registerBox">
		<?php
		  if ($step==2)
			{
			  $name = $_POST['name'];
				$email = $_POST['email'];
				$pw1 = $_POST['pw1'];
				$pw2 = $_POST['pw2'];
				$error = false;
				$enum = 0;
			
			  if (stristr($pw1, "-"))
				{
				  $error = "Password cannot contain '-'!";
					$enum = 1;
					$step = 1;
				}
				else if (stristr($pw1, "'") or stristr($pw1,"\""))
				{
				  $error = "Password cannot contain quotes";
					$enum = 1;
					$step = 1;
				}
				else if ($pw1!=$pw2)
				{
				  $error = "Passwords don't match!";
					$enum = 2;
					$step = 1;
				}
				
				else if ($step==2)
				{
				  $name = clean($name);
					$email = clean($email);
					$pw1 = clean($pw1);
					$pw1 = crypt($pw1);
				  $query = mysql_query("INSERT INTO Unconfirmed (Name, Email, Password) VALUES('$name', '$email', '$pw1')", $website);
					$query = mysql_query("SELECT * FROM Unconfirmed ORDER BY Id DESC LIMIT 1", $website);
					$data = mysql_fetch_array($query);
					$id = $data[0];
				
				  $text = "<html><head><title>22nd Century Games - Registration</title></head><body>";
					$text .= "This email ($email) has been registered at <a href=\"http://www.22ndcg.org/\">22nd Century Games</a> by $name.<br><br>";
					$text .= "Confirm your registration <a href=\"http://www.22ndcg.org/confirm.php?id=$id&cmd=c\">here</a>.<br>";
					$text .= "Not you? You can delete your account <a href=\"http://www.22ndcg.org/confirm.php?id=$id&cmd=d\">here</a>.";
					$text .= "</body></html>";
					
					mail($email, "22nd Century Gaming - Registration Confirmation", $text, "From: admin@22ndcg.org\r\nContent-type: text/html;/r/n");
					
					print "<p class=\"registerError\">A confirmation email has been sent to <i>$email</i>. When you get the email, just click on the link to activate your account.</p>";
					print "<br>";
				}
			}
		  if ($step==1)
			{
				print "<form action=\"register.php\" method=\"post\">";
				print "<input type=\"hidden\" name=\"step\" value=\"2\"/>";
				print "<p class=\"registerError\">Register</p>";
				print "Name: <input type=\"text\" size=\"30\" name=\"name\" value=\"$name\"/><br>";
				print "Email: <input type=\"text\" size=\"45\" name=\"email\" value=\"$email\"/><br>";
				if ($enum==1)
				print "<p class=\"error\">$error</p>";
				print "Password: <input type=\"password\" size=\"20\" name=\"pw1\"/><br>";
				if ($enum==2)
				print "<p class=\"error\">$error</p>";
				print "Confirm: <input type=\"password\" size=\"20\" name=\"pw2\"/><br>";
				print "<input type=\"submit\" value=\"Register\"/>";
				print "</form>";
				print "<br>";
			}
		?>
		</div></div>
		<br>
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
