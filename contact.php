<?php
  include("Util/Clean.php"); 
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("h2ndxygv_Main", $website);
	
	$curFile = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
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
	  <h1 id="title">Contact us</h1>
		<p id="siteDesc">If your having technical trouble with one of our games, questions about anything 22ndCG or just want to tell us we're awesome, you're in the right place!
		<br><br>If you want to contact a certain team member directly, you can get their email by clicking on their names on <a href="team.php">this page</a><br><br>
		If you want to learn something about a game (easter eggs, etc), try posting on that game's forum, as we'll never tell our secrets!</p>
		<?php
		  $sent = $_POST['sent'];
			$enum = 0;
			$error = "none";
			
			if ($sent)
			{
			  $name = $_POST['name'];
				$email = $_POST['email'];
				$body = $_POST['body'];
				
				if (!$name)
				{
				  $error = "You have a name right?";
					$enum = 1;
					$sent = false;
				}
				else if (!$email)
				{
				  $error = "How do you expect us to reply?";
					$enum = 2;
					$sent = false;
				}
				else if (!$body)
				{
				  $error = "Did you forget what you were going to say?";
					$enum = 3;
					$sent = false;
				}
				else
				{
				  $message = $body;
					$message .= "\r\n\r\n\r\n    From,\r\n$name ($email)";
					mail("benreid@buffalo.edu,chriszosh96@gmail.com,themilkmentaskforce@gmail.com", "$name", $message, "From: admin@22ndcg.org");
					print "<div style=\"padding-left: 150px;\"><p class=\"success\">Your issue has been submited. You can expect a response within 3 business days. If you don't, try submiting another form yelling at us to get on top of things</p></div>";
				}
			}
			if (!$sent)
			{
			  print "Feel free to shoot us an email <a href=\"mailto:benreid@buffalo.edu\">here</a> or fill out the form below.</p>";
				print "<form action=\"contact.php\" method=\"post\">";
				if ($enum==1)
				print "<p class=\"error\">$error</p>";
				print "Name: <input type=\"text\" size=\"20\" name=\"name\" value=\"$name\"/><br>";
				if ($enum==2)
				print "<p class=\"error\">$error</p>";
				print "Email: <input type=\"text\" size=\"40\" name=\"email\" value=\"$email\"/><br>";
				if ($enum==3)
				print "<p class=\"error\">$error</p>";
				print "Your problem:<br><textarea rows=\"15\" cols=\"60\" name=\"body\"/>$body</textarea><br>";
				print "<input type=\"submit\" value=\"Submit\" name=\"sent\"/>";
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

