<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("hqlkiaju_Main", $website);
	
	$curFile = $_SERVER['REQUEST_URI'];
	$user = $_GET['user'];
	
	$tmp = mysql_query("SELECT * FROM Admins", $website);
	while ($data = mysql_fetch_array($tmp))
	{
	  if ($data[0]==$user)
		Header("Location: http://www.22ndcg.com/team.php#$user");
	}
	
	//redirect admins
	if ($_SESSION['admin'] && !$user)
	Header("Location: http://www.22ndcg.com/admin.php?cmd=profile");
	
	if (!$_SESSION['name'] || $_SESSION['name']=="out")
	Header("Location: http://www.22ndcg.com/login.php?referer=$curFile&e=You+must+login+to+see+this+page!");
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="Styles/account.css" rel="stylesheet" type="text/css">
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
	  <?php
			$cmd = $_GET['action'];
			if (!isset($cmd))
			$cmd = $_POST['cmd'];
		  
			if ($cmd=="chngpw")
			{
			  $query = mysql_query("SELECT * FROM Users WHERE Username='".$_SESSION['name']."'", $website);
				$data = mysql_fetch_array($query);
			  $opw = $_POST['opw'];
				$npw1 = $_POST['npw1'];
				$npw2 = $_POST['npw2'];
				$done = $_POST['done'];
				$error = "none";
				$enum = 0;
				
				if ($done)
				{
				  if (!$opw)
					{
					  $error = "You must enter your old password!";
						$enum = 1;
						$done = false;
					}
					else if (!$npw1)
					{
					  $error = "You must enter a new password!";
						$enum = 2;
						$done = false;
					}
					else if (!$npw2)
					{
					  $error = "You must confirm your new password!";
						$enum = 3;
						$done = false;
					}
					else if ($opw!=$data[2])
					{
					  $error = "This password is incorrect!";
						$enum = 4;
						$done = false;
					}
					else if (strstr($npw1, "-"))
					{
					  $error = "Password cannot contain '-'!";
						$enum = 5;
						$done = false;
					}
					else if (strstr($npw1, "'"))
					{
					  $error = "Password cannot contain \" ' \"!";
						$enum = 5;
						$done = false;
					}
					else if ($npw1!=$npw2)
					{
					  $error = "Your passwords don't match!";
						$enum = 6;
						$done = false;
					}
					else
					{
					  mysql_query("UPDATE Users SET Password='$npw1' WHERE Username='".$_SESSION['name']."'", $website);
						print "<div style=\"padding-left: 200px;\"><p class=\"success\">Your password have been successfully changed.</p>(Page will reset in 3 seconds)</div>";
						print "<meta http-equiv=\"refresh\" content=\"3; url=http://www.22ndcg.com/account.php\">";
					}
				}
				if (!$done)
				{
				  print "<form action=\"account.php\" method=\"post\">";
				  if ($enum==1 || $enum==4)
					print "<p class=\"error\">$error</p>";
					print "Old Password: <input type=\"password\" name=\"opw\" size=\"25\"/><br>";
					if ($enum==2 || $enum==5)
					print "<p class=\"error\">$error</p>";
					print "New Password: <input type=\"password\" name=\"npw1\" size=\"25\"/><br>";
					if ($enum==3 || $enum==6)
					print "<p class=\"error\">$error</p>";
					print "Confirm: <input type=\"password\" name=\"npw2\" size=\"25\"/><br>";
					print "<input type=\"hidden\" name=\"cmd\" value=\"chngpw\"/>";
					print "<input type=\"submit\" name=\"done\" value=\"Save\"/>";
					print "</form>";
				}
			}
			else if (!$user)
			{
		  	$query = mysql_query("SELECT * FROM Users WHERE Username='".$_SESSION['name']."'", $website);
				$data = mysql_fetch_array($query);
		
		  	$changed = $_POST['chnged'];
			
				if ($changed)
				{
					$email = $_POST['email'];
					$motto = $_POST['motto'];
					$bio = $_POST['bio'];
					
					if (!$_FILES['pic']['name'])
					$pic = $data[5];
					else if ($_FILES['pic']['error']>0)
					$pic = $data[5];
					else
					{
					  $tname = "User Pics/".$_FILES['pic']['name'];
						if (stristr($_FILES['pic']['type'], "image") && $_FILES['size']<5242880)
						{
						  $pic = $tname;
							$pic = clean($pic);
							copy($_FILES['pic']['tmp_name'], "User Pics/".$_FILES['pic']['name']);
						}
					}
					
					$email = clean($email);
					$motto = clean($motto);
					$bio = clean($bio);
					mysql_query("UPDATE Users SET Email='$email', Motto='$motto', Pic='$pic', Bio='$bio' WHERE Username='".$_SESSION['name']."'", $website);
					$query = mysql_query("SELECT * FROM Users WHERE Username='".$_SESSION['name']."'", $website);
				  $data = mysql_fetch_array($query);
					
					print "<div style=\"padding-left: 200px;\"><p class=\"success\">Your changes have been saved.</p></div>";
				}
				
				print "<h1 id=\"title\">My Account</h1>";
		    print "<p id=\"siteDesc\">Edit your personal information here.</p>";
				print "<div style=\"padding: 30px\"><div style=\"border: 2px solid black; background: #9f9f9f;\">";
				print "<form action=\"account.php\" method=\"post\" enctype=\"multipart/form-data\">";
				print "<br><a href=\"account.php?user=".$_SESSION['name']."\">Public View</a><br><br>";
				print "Email: <input type=\"text\" name=\"email\" value=\"".$data[3]."\" size=\"40\"/><br>";
				print "<a href=\"account.php?action=chngpw\">Change Password</a><br>";
				print "Motto: <input type=\"text\" name=\"motto\" value=\"".$data[7]."\" size=\"40\"/><br>";
				print "Profile Picture: <input type=\"file\" name=\"pic\" size=\"60\"/><br>";
				print "Bio:<br><textarea name=\"bio\" rows=\"15\" cols=\"40\">".$data[4]."</textarea><br>";
				print "<input type=\"submit\" value=\"Save\" name=\"chnged\"/>";
				print "</form></div></div>";
			}
			else
			{
			  $query = mysql_query("SELECT * FROM Users WHERE Username='$user'", $website);
				$data = mysql_fetch_array($query);
				
				print "<div style=\"padding: 30px;\"><div style=\"border: 2px solid black;\">";
			  print "<h1 id=\"title\">".$data[1]."</h1>";
				print "<img src=\"".$data[5]."\" alt=\"No picture\" id=\"acPic\">";
				print "<p id=\"acMotto\">".$data[7]."</p><br>";
				print "<p><span class=\"acTxt\">Bio:</span> ".$data[4]."</p>";
				print "<p><span class=\"acTxt\">Email:</span> <a href=\"mailto:".$data[3]."\">".$data[3]."</a></p>";
				print "</div></div>";
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
