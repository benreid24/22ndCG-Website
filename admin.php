<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  $curFile = $_SERVER['REQUEST_URI'];
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("h2ndxygv_Main", $website);
	
	if (!$_SESSION['name'] || $_SESSION['name']=="out")
	Header("Location: http://www.22ndcg.org/login.php?referer=$curFile&e=You+must+login+to+see+this+page!");
	else if (!$_SESSION['admin'])
	Header("Location: http://www.22ndcg.org/login.php?referer=$curFile&e=You+do+not+have+permision+to+view+this+page!");
	
	$cmd = $_GET['cmd'];
	if (!isset($cmd))
	$cmd = $_POST['cmd'];
	if (!isset($cmd))
	$cmd = "main";
?>

<html>
<head>
<title>22nd Century Gaming - Admin</title>
<link rel="stylesheet" href="Styles/admin.css" type="text/css">
<link rel="stylesheet" href="Styles/styles.css" type="text/css">
<link rel="stylesheet" href="Styles/games.css" type="text/css">
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
	  <a href="admin.php"><h1 id="title">Admin</h1></a>
		<?php
		  if ($cmd=="main")
			{
			    print "<a href=\"admin.php?cmd=profile\" class=\"adminLink\">My Profile</a><br><br>";
				print "<a href=\"admin.php?cmd=games\" class=\"adminLink\">Games</a><br><br>";
				print "<a href=\"admin.php?cmd=news\" class=\"adminLink\">News</a><br><br>";
				print "<a href=\"admin.php?cmd=users\" class=\"adminLink\">Users</a><br><br>";
				print "<a href=\"admin.php?cmd=upload\" class=\"adminLink\"\">Upload Files</a><br><br>";
			}
			if ($cmd=="profile")
			{
			  $changed = $_POST['changed'];
				$action = $_GET['action'];
				if (!$action)
				$action = $_POST['action'];
				$query = mysql_query("SELECT * FROM Admins WHERE Username='".$_SESSION['name']."'", $website);
				$data = mysql_fetch_array($query);
				
				if ($action=="pw")
				{
				  $done = $_POST['done'];
					$error = "none";
					$enum = 0;
					
					if ($done)
					{
					  $opw = $_POST['opw'];
						$npw1 = $_POST['npw1'];
						$npw2 = $_POST['npw2'];
					
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
						else if ($opw!=$data[1])
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
						  mysql_query("UPDATE Admins SET Password='$npw1' WHERE Username='".$_SESSION['name']."'", $website);
							print "<div style=\"padding-left: 150px;\"><p class=\"success\">Your password has been changed.</p></div>";
							print "<meta http-equiv=\"refresh\" content=\"3; url=http://www.22ndcg.org/admin.php?cmd=profile\">";
						}
					}
					if (!$done)
					{
					  print "<br><form action=\"admin.php\" method=\"post\">";
						print "<input type=\"hidden\" name=\"cmd\" value=\"profile\"/>";
						print "<input type=\"hidden\" name=\"action\" value=\"pw\"/>";
						if ($enum==1 || $enum==4)
						print "<p class=\"error\">$error</p>";
						print "Old Password: <input type=\"password\" name=\"opw\" size=\"25\"/><br>";
						if ($enum==2 || $enum==5)
						print "<p class=\"error\">$error</p>";
						print "New Password: <input type=\"password\" name=\"npw1\" size=\"25\"/><br>";
						if ($enum==3 || $enum==6)
						print "<p class=\"error\">$error</p>";
						print "Confirm: <input type=\"password\" name=\"npw2\" size=\"25\"/><br>";
						print "<input type=\"submit\" name=\"done\" value=\"Save\"/>";
						print "</form><br>";
					}
				}
				
				if ($changed)
				{
				  $email = $_POST['email'];
					$motto = $_POST['motto'];
					$caption = $_POST['caption'];
					$bio = $_POST['bio'];
					$job = $_POST['job'];
					
					if ($_FILES['pic']['error']>0)
					$pic = $data[3];
					else if (!$_FILES['pic']['name'])
					$pic = $data[3];
					else
					{
					  if (stristr($_FILES['pic']['type'], "image") && $_FILES['pic']['size']<=5242880)
						{
						  $pic = "Team Pics/".$_FILES['pic']['name'];
							copy($_FILES['pic']['tmp_name'], $pic);
						}
						else
						$pic = $data[3];
					}
					$email = clean($email);
					$motto = clean($motto);
					$caption = clean($caption);
					$bio = clean($bio);
					$job = clean($job);
					mysql_query("UPDATE Admins SET Email='$email', Bio='$bio', Motto='$motto', Caption='$caption', Job='$job', Image='$pic' WHERE Username='".$_SESSION['name']."'", $website);
					$query = mysql_query("SELECT * FROM Admins WHERE Username='".$_SESSION['name']."'", $website);
					$data = mysql_fetch_array($query);
				}
				
				if ($action!="pw")
				{
				  print "<div style=\"padding: 30px\"><div style=\"border: 2px solid black; background: #9f9f9f;\">";
					print "<form action=\"admin.php\" method=\"post\" enctype=\"multipart/form-data\">";
					print "<input type=\"hidden\" name=\"cmd\" value=\"profile\"/>";
					print "<br><a href=\"team.php#".$_SESSION['name']."\">Public View</a><br><br>";
					print "Email: <input type=\"text\" name=\"email\" value=\"".$data[8]."\" size=\"40\"/><br>";
					print "<a href=\"admin.php?cmd=profile&action=pw\">Change Password</a><br>";
					print "Motto: <input type=\"text\" name=\"motto\" value=\"".$data[6]."\" size=\"40\"/><br>";
					print "Profile Picture: <input type=\"file\" name=\"pic\" size=\"60\"/><br>";
					print "Caption:<br><textarea name=\"caption\" cols=\"30\" rows=\"5\">".$data[7]."</textarea><br>";
					print "Bio:<br><textarea name=\"bio\" rows=\"15\" cols=\"40\">".$data[2]."</textarea><br>";
					print "Job: <input type=\"text\" name=\"job\" size=\"50\" value=\"".$data[4]."\"/><br>";
					print "<input type=\"submit\" value=\"Save\" name=\"changed\"/>";
					print "</form></div></div>";
				}
			}
			if ($cmd=="users")
			{
			  $action = $_GET['action'];
				$user = $_GET['user'];
				
				if ($action=="del")
				{
				  $query = mysql_query("SELECT * FROM Users WHERE Id='$user'", $website);
					$data = mysql_fetch_array($query);
					
					$to = $data[3];
					$headers = "From: admin@22ndcg.org\r\nContent-type: text/html;\r\n";
					$subject = "22nd Century Games - Account Deletion Notice";
					$message = "<html><head><title>22nd Century Games - Account Deletion Notice</title></head><body>";
					$message .= "Dear ".$data[1].",<br>";
					$message .= "<p style=\"text-indent: 15pt;\">Your account at <a href=\"http://www.22ndcg.org\">22nd Century Games</a> has been deleted due to us receiving numerous complaints about your online activity on our site. If you need more information, or feel that this was a mistake, <a href=\"mailto:admin@22ndcg.org\">Contact Us</a>.</p>";
					$message .= "Thanks,<br><a href=\"http://www.22ndcg.org/team.php\">The 22nd Century Gaming Team</a>";
					$message .= "</body></html>";
					mail($to, $subject, $message, $headers);
					
					mysql_query("DELETE FROM Users WHERE Id='$user'", $website);
					
					print "<div style=\"padding-left: 150px;\"><p class=\"success\">".$data[1]."'s account has been deleted</p></div>";
				}
			
			  $query = mysql_query("SELECT * FROM Users ORDER BY Complaints DESC", $website);
				
				print "<h2>Users:</h2>";
				while ($data = mysql_fetch_array($query))
				{
					print "<div style=\"padding-left: 330px;\"><div class=\"adUser\">";
					print "<a href=\"account.php?user=".$data[1]."\"><h3>".$data[1]."</h3></a>";
					print "Complaints: ".$data[6]."<br><a href=\"admin.php?cmd=users&action=del&user=".$data[0]."\">Delete</a>";
					print "</div></div><br><br>";
				}
			}
			if ($cmd=="games")
			{
			  $opt = $_GET['opt'];
				if (!$opt)
				$opt = $_POST['opt'];
				
				if (!$opt)
				{
				  print "<a href=\"admin.php?cmd=games&opt=new\" class=\"adminLink\">New Game</a><br><br>";
					print "<a href=\"admin.php?cmd=games&opt=edit\" class=\"adminLink\">Edit Games</a><br><br>";
					print "<a href=\"admin.php?cmd=games&opt=del\" class=\"adminLink\">Delete Games</a><br><br>";
				}
				if ($opt=="new")
				{
				  $done = $_POST['done'];
					
					if ($done)
					{
					  $status = "Conceptual";
						$name = $_POST['name'];
						$desc = $_POST['desc'];
						$members = $_POST['members'];
						$download = "games.php";
						if ($_FILES['logo']['error']>0)
						$pic = "";
						else if (!$_FILES['logo']['name'])
						$pic = "";
						else
						{
					    if (stristr($_FILES['logo']['type'], "image") && $_FILES['logo']['size']<=5242880)
							{
						    $pic = "Images/".$_FILES['logo']['name'];
								copy($_FILES['logo']['tmp_name'], $pic);
						  }
							else
							$pic = "";
						}
						
						$name = clean($name);
						$desc = clean($desc);
						$members = clean($members);
						mysql_query("INSERT INTO Game (Description, Name, Logo, Members, Status, File) VALUES('$desc', '$name', '$pic', '$members', '$status', '$download')", $website);
						$tq = mysql_query("SELECT * FROM Game WHERE Name='$name'", $website);
						$td = mysql_fetch_array($tq);
						$id = $td[3];
						mysql_query("INSERT INTO Forum (Game, Name, Description) VALUES('$id', 'Support', 'Get technical assistance or help with a part of the game your stuck on here.')", $website);
						mysql_query("INSERT INTO Forum (Game, Name, Description) VALUES('$id', 'General', 'Talk about any aspect of the game, such as bugs and easter eggs, in here.')", $website);
						print "<pre>                               <p class=\"success\">$name has been created!</p></pre>";
						print "<a href=\"admin.php?cmd=games\">Back</a>";
					}
					else
					{
					  print "<form action=\"admin.php\" method=\"post\" class=\"adForm\" enctype=\"multipart/form-data\">";
						print "<input type=\"hidden\" name=\"cmd\" value=\"games\"/>";
						print "<input type=\"hidden\" name=\"opt\" value=\"new\"/>";
						print "Name: <input type=\"text\" name=\"name\" size=\"30\"/><br>";
						print "Description/Concept:<br>";
						print "<textarea cols=\"60\" rows=\"15\" name=\"desc\"></textarea><br>";
						print "Logo: <input type=\"file\" name=\"logo\"/><br>";
						print "Members: <input type=\"text\" size=\"40\" name=\"members\"/><br>";
						print "<input type=\"submit\" name=\"done\" value=\"Post\"/><br>";
						print "</form>";
					}
				}
				if ($opt=="del")
				{
				  $game = $_GET['game'];
					
					if (isset($game))
					{
					  $forums = mysql_query("SELECT * FROM Forum WHERE Game='$game'", $website);
						while ($fData = mysql_fetch_array($forums))
						{
						  $threads = mysql_query("SELECT * FROM Threads WHERE Forum='".$fData[1]."'", $website);
							while ($tData = mysql_fetch_array($threads))
							{
							  mysql_query("DELETE FROM ForumPosts WHERE Thread='".$tData[3]."'", $website);
							}
							mysql_query("DELETE FROM Threads WHERE Forum='".$fData[1]."'", $website);
						}
						mysql_query("DELETE FROM Forum WHERE Game='$game'", $website);
						mysql_query("DELETE FROM Game WHERE Id='$game'", $website);
						print "<pre>                               <p class=\"success\">Game $game was deleted. Ass</p></pre>";
						print "<meta http-equiv=\"refresh\" content=\"2;http://www.22ndcg.org/admin.php?cmd=games&opt=del\">";
					}
					else
					{
					  $query = mysql_query("SELECT * FROM Game", $website);
						
						while ($data = mysql_fetch_array($query))
						{
						  print "<a href=\"admin.php?cmd=games&opt=del&game=".$data[3]."\" class=\"adminLink\">".$data[0]."</a><br><br>";
						}
					}
				}
				if ($opt=="edit")
				{
				  $game = $_GET['game'];
					if (!isset($game))
					$game = $_POST['game'];
					
					if (isset($game))
					{
					  $sopt = $_GET['sopt'];
						if (!isset($sopt))
						$sopt = $_POST['sopt'];
						
						if (!$sopt)
						{
						  print "<a href=\"admin.php?cmd=games&opt=edit&game=$game&sopt=stat\" class=\"adminLink\">Development Status</a><br><br>";
							print "<a href=\"admin.php?cmd=games&opt=edit&game=$game&sopt=dev\" class=\"adminLink\">Development Updates</a><br><br>";
							print "<a href=\"admin.php?cmd=games&opt=edit&game=$game&sopt=data\" class=\"adminLink\">Game Data</a><br><br>";
						}
						if ($sopt=="stat")
						{
						  $done = $_POST['done'];
							
							if ($done)
							{
							  $stat = $_POST['stat'];
								mysql_query("UPDATE Game SET Status='$stat' WHERE Id='$game'", $website);
								print mysql_error();
								print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/admin.php?cmd=games&opt=edit&sopt=stat&game=$game\">";
							}
							else
							{
							  print "<form action=\"admin.php\" method=\"post\">";
								print "<input type=\"hidden\" name=\"cmd\" value=\"games\"/>";
								print "<input type=\"hidden\" name=\"opt\" value=\"edit\"/>";
								print "<input type=\"hidden\" name=\"sopt\" value=\"stat\"/>";
								print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
								print "Status: <select name=\"stat\"><option>Conceptual</option><option>Early Design</option><option>Mid Design</option><option>Late Design</option><option>Early Production</option><option>Mid Production</option><option>Late Production</option><option>Pre-Release QA</option><option>Released (Updated)</option><option>Released (Abandoned)</option><option>Suspended</option><option>Canceled</option></select>";
								print "<br><input type=\"submit\" name=\"done\" value=\"Save\"/>";
								print "</form>";
							}
						}
						if ($sopt=="dev")
						{
						  $dopt = $_GET['dopt'];
							if (!isset($dopt))
							$dopt = $_POST['dopt'];
							
							if (!$dopt)
							{
							  print "<a href=\"admin.php?cmd=games&opt=edit&sopt=dev&game=$game&dopt=new\" class=\"adminLink\">New Update</a><br><br>";
								print "<a href=\"admin.php?cmd=games&opt=edit&sopt=dev&game=$game&dopt=edit\" class=\"adminLink\">Edit Updates</a><br><br>";
								print "<a href=\"admin.php?cmd=games&opt=edit&sopt=dev&game=$game&dopt=del\" class=\"adminLink\">Delete Updates</a><br><br>";
							}
							if ($dopt=="new")
							{
							  $done = $_POST['done'];
								
								if ($done)
								{
								   $title = $_POST['title'];
									 $poster = $_SESSION['name'];
									 $cont = $_POST['cont'];
									 $date = date("D M d").", ".date("Y");
									 $title = clean($title);
									 $cont = clean($cont);
									 mysql_query("INSERT INTO DevUpdates (Game, Title, Poster, Content, Date) VALUES ('$game', '$title', '$poster', '$cont', '$date')", $website);
									 print "<meta http-equiv=\"refresh\" content=\"0;admin.php?cmd=games&opt=edit&sopt=dev\">";
								}
								else
								{
								  print "<form action=\"admin.php\" method=\"post\">";
									print "<input type=\"hidden\" name=\"cmd\" value=\"games\"/>";
									print "<input type=\"hidden\" name=\"opt\" value=\"edit\"/>";
									print "<input type=\"hidden\" name=\"sopt\" value=\"dev\"/>";
									print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
									print "<input type=\"hidden\" name=\"dopt\" value=\"new\"/>";
									print "Title: <input type=\"text\" name=\"title\" size=\"40\"/><br>";
									print "Content:<br><textarea cols=\"50\" cols=\"20\" name=\"cont\"></textarea><br>";
									print "<input type=\"submit\" name=\"done\" value=\"Post\"/>";
									print "</form>";
								}
							}
							if ($dopt=="edit")
							{
								$done = $_POST['done'];
									
								if ($done)
								{
									$id = $_POST['id'];
									$title = $_POST['title'];
									$cont = $_POST['cont'];
									$cont = clean($cont);
									$title = clean($title);
									mysql_query("UPDATE DevUpdates SET Title='$title', Content='$cont' WHERE Id='$id'", $website);
									print "<meta http-equiv=\"refresh\" content=\"0;admin.php?cmd=games&opt=edit&sopt=dev&game=$game&dopt=edit\">";
								}
								else
								{
								  $query = mysql_query("SELECT * FROM DevUpdates WHERE Game='$game' ORDER BY Id DESC", $website);
									while ($data = mysql_fetch_array($query))
									{
									  print "<form action=\"admin.php\" method=\"post\" class=\"adForm\">";
										print "<input type=\"hidden\" name=\"cmd\" value=\"games\"/>";
										print "<input type=\"hidden\" name=\"opt\" value=\"edit\"/>";
										print "<input type=\"hidden\" name=\"sopt\" value=\"dev\"/>";
										print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
										print "<input type=\"hidden\" name=\"dopt\" value=\"edit\"/>";
										print "<input type=\"hidden\" name=\"id\" value=\"".$data[5]."\"/>";
										print "Title: <input type=\"text\" name=\"title\" size=\"40\" value=\"".$data[1]."\"/><br>";
										print "Content:<br><textarea cols=\"60\" rows=\"20\" name=\"cont\">".$data[3]."</textarea><br>";
										print "<input type=\"submit\" name=\"done\" value=\"Save\"/>";
										print "</form><br><br>";
									}
								}
							}
							if ($dopt=="del")
							{
							  $id = $_GET['id'];
								if (isset($id))
								{
								  mysql_query("DELETE FROM DevUpdates WHERE Id='$id'", $website);
									print "<meta http-equiv=\"refresh\" content=\"0;admin.php?cmd=games&opt=edit&sopt=dev&dopt=del&game=$game\">";
								}
							
							  $query = mysql_query("SELECT * FROM DevUpdates WHERE Game='$game' ORDER BY Id DESC", $website);
								while ($data = mysql_fetch_array($query))
								{
								 print "<a style=\"text-align: center;\" href=\"admin.php?cmd=games&opt=edit&sopt=dev&game=$game&dopt=del&id=".$data[0]."\"><div class=\"gmUpdate\">";
								 print "<h2 class=\"gmUpdateTitle\">".$data[1]."</h2>";
								 print "<p class=\"gmUpdateCont\">".$data[3]."</p>";
								 print "<p><span class=\"gmUpdatePoster\">".$data[2]."</span><span class=\"gmUpdateDate\">".$data[4]."</span></p>";
								 print "</div></a>";
								}
							}
						}
						if ($sopt=="data")
						{
						  $done = $_POST['done'];
							
							if ($done)
							{
							  $query = mysql_query("SELECT * FROM Game WHERE Id='$game'", $website);
								$data = mysql_fetch_array($query);
							  $name = $_POST['name'];
								$desc = $_POST['desc'];
								$members = $_POST['members'];
								$upfile = $_POST['upfile'];
								if ($_FILES['logo']['error']>0)
								$pic = $data[2];
								else if (!$_FILES['logo']['name'])
								$pic = $data[2];
								else
								{
					  		  if (stristr($_FILES['logo']['type'], "image") && $_FILES['logo']['size']<=5242880)
									{
						  		  $pic = "Images/".$_FILES['logo']['name'];
										copy($_FILES['logo']['tmp_name'], $pic);
						      }
									else
									$pic = $data[2];
								}
								if ($_FILES['butt']['error']>0)
								$butt = $data[7];
								else if (!$_FILES['butt']['name'])
								$butt = $data[7];
								else
								{
					  		  if (stristr($_FILES['butt']['type'], "image") && $_FILES['butt']['size']<=5242880)
									{
						  		  $butt = "Images/".$_FILES['butt']['name'];
										copy($_FILES['butt']['tmp_name'], $butt);
						      }
									else
									$butt = $data[7];
								}
								
								$name = clean($name);
								$desc = clean($desc);
								$members = clean($members);
								mysql_query("UPDATE Game SET Name='$name', Description='$desc', Logo='$pic', Members='$members', DownloadImage='$butt', File='$upfile' WHERE Id='$game'", $website);
								print "<meta http-equiv=\"refresh\" content=\"0;admin.php?cmd=games&opt=edit&game=$game&sopt=data\">";
							}
							else
							{
							  $query = mysql_query("SELECT * FROM Game WHERE Id='$game'", $website);
								$data = mysql_fetch_array($query);
								
							  print "<form action=\"admin.php\" method=\"post\" enctype=\"multipart/form-data\" class=\"adForm\">";
								print "<input type=\"hidden\" name=\"cmd\" value=\"games\"/>";
								print "<input type=\"hidden\" name=\"opt\" value=\"edit\"/>";
								print "<input type=\"hidden\" name=\"sopt\" value=\"data\"/>";
								print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
								print "Name: <input type=\"text\" size=\"25\" value=\"".$data[0]."\" name=\"name\"/><br>";
								print "Description:<br><textarea name=\"desc\" cols=\"60\" rows=\"20\">".$data[1]."</textarea><br>";
								print "Logo: <input type=\"file\" name=\"logo\"/><br>";
								print "Download button: <input type=\"file\" name=\"butt\"/><br>";
								print "Uploaded Gamefile Name: <input type=\"text\" size=\"40\" name=\"upfile\" value=\"".$data[5]."\"/><br>";
								print "Members: <input type=\"text\" size=\"50\" name=\"members\" value=\"".$data[4]."\"/><br>";
								print "<input type=\"submit\" name=\"done\" value=\"Save\"/>";
								print "</form>";
							}
						}
					}
					else
					{
					  $query = mysql_query("SELECT * FROM Game", $website);
						while ($data = mysql_fetch_array($query))
						{
						  print "<a href=\"admin.php?cmd=games&opt=edit&game=".$data[3]."\" class=\"adminLink\">".$data[0]."</a><br><br>";
						}
					}
				}
			}
			if ($cmd=="news")
			{
			  $opt = $_GET['opt'];
				if (!isset($opt))
				$opt = $_POST['opt'];
				
				if (!$opt)
			  {
				  print "<a href=\"admin.php?cmd=news&opt=add\" class=\"adminLink\">Add News Post</a><br><br>";
				  print "<a href=\"admin.php?cmd=news&opt=edit\" class=\"adminLink\">Edit News Posts</a><br><br>";
				  print "<a href=\"admin.php?cmd=news&opt=del\" class=\"adminLink\">Delete News Posts</a><br><br>";
				}
				if ($opt=="edit")
				{
				  $post = $_GET['post'];
					if (!isset($post))
					$post = $_POST['post'];
					
					if ($post)
					{
					  $done = $_POST['done'];
						
						if (!$done)
						{
						  $query = mysql_query("SELECT * FROM News WHERE Id='$post'", $website);
							$data = mysql_fetch_array($query);
							$title = $data[4];
							$body = $data[3];
							$name = $data[1];
						  print "<form action=\"admin.php\" method=\"post\">";
							print "<input type=\"hidden\" name=\"cmd\" value=\"news\"/>";
							print "<input type=\"hidden\" name=\"opt\" value=\"edit\"/>";
							print "<input type=\"hidden\" name=\"post\" value=\"$post\"/>";
							print "<input type=\"hidden\" name=\"poster\" value=\"".$_SESSION['name']."\"/>";
							print "Title: <input type=\"text\" name=\"title\" value=\"$title\" size=\"30\"/><br><br>";
							print "Body:<br><textarea cols=\"50\" rows=\"15\" name=\"body\">$body</textarea><br><br>";
							print "<input type=\"submit\" name=\"done\" value=\"Done\"/>";
						}
						else
						{
						  $body = $_POST['body'];
							$post = $_POST['post'];
							$name = $_POST['poster'];
							$title = $_POST['title'];
							$body = clean($body);
							$title = clean($title);
							mysql_query("UPDATE News SET Poster='$name', Content='$body', Title='$title' WHERE Id='$post'", $website);
							$post = false;
						}
					}
					
					if (!$post)
					{
				    $query = mysql_query("SELECT * FROM News ORDER BY Id DESC", $website);
						while ($data = mysql_fetch_row($query))
						{
					    print "<a href=\"admin.php?cmd=news&opt=edit&post=".$data[0]."\ style=\"text-decoration: none;\">";
			  	  	print "<div class=\"newsPost\">";
							print "<h2 class=\"newsTitle\">".$data[4]."</h2>";
							print "<p class=\"newsContent\">".$data[3]."</p>";
							print "<a href=\"team.php#".$data[1]."\"><span class=\"newsPoster\">".$data[1]."</span></a>";
							print "<span class=\"newsDate\">".$data[2]."</span>";
							print "</div></a><br><br>";
			    	}
					}
				}
				if ($opt=="del")
				{
				  $post = $_GET['post'];
					
					if ($post)
					{
					  mysql_query("DELETE FROM News WHERE Id='$post'", $website);
						$post = false;
					}
					
					if (!$post)
					{
					  $query = mysql_query("SELECT * FROM News ORDER BY Id DESC", $website);
						while ($data = mysql_fetch_row($query))
						{
					    print "<a href=\"admin.php?cmd=news&opt=del&post=".$data[0]."\" style=\"text-decoration: none;\">";
			  	  	print "<div class=\"newsPost\">";
							print "<h2 class=\"newsTitle\">".$data[4]."</h2>";
							print "<p class=\"newsContent\">".$data[3]."</p>";
							print "<a href=\"team.php#".$data[1]."\"><span class=\"newsPoster\">".$data[1]."</span></a>";
							print "<span class=\"newsDate\">".$data[2]."</span>";
							print "</div></a><br><br>";
			    	}
					}
				}
				if ($opt=="add")
				{
				  $done = $_POST['done'];
					$date = date("D M d").", ".date("Y");
					
					if (!$done)
					{
					  print "<form action=\"admin.php\" method=\"post\">";
						print "<input type=\"hidden\" name=\"date\" value=\"$date\"/>";
						print "<input type=\"hidden\" name=\"poster\" value=\"".$_SESSION['name']."\"/>";
						print "<input type=\"hidden\" name=\"cmd\" value=\"news\"/>";
						print "<input type=\"hidden\" name=\"opt\" value=\"add\"/>";
						print "Title: <input type=\"text\" name=\"title\" size=\"30\"/><br><br>";
						print "Body:<br><textarea name=\"body\" cols=\"50\" rows=\"20\"></textarea><br><br>";
						print "<input type=\"submit\" name=\"done\" value=\"Post\"/>";
						print "</form>";
					}
					else
					{
					  $title = $_POST['title'];
						$body = $_POST['body'];
						$poster = $_POST['poster'];
						$date = $_POST['date'];
						$title = clean($title);
						$body = clean($body);
						mysql_query("INSERT INTO News (Poster, Date, Content, Title) VALUES('$poster', '$date', '$body', '$title')", $website);
						print "Successfully posted!<br><a href=\"admin.php\">Back</a><br>";
						print "INSERT INTO News (Poster, Date, Content, Title) VALUES('$poster', '$date', '$body', '$title')";
					}
				}
			}
			if ($cmd=="upload")
			{
			  $done = $_POST['done'];
				
				if ($done)
				{
				  $path = $_POST['loc'];
					if ($path=="Root")
					$path = "";
					$pic = $_FILES['upload']['name'];
					
					copy($_FILES['upload']['tmp_name'],$path.$pic);
					print "<p class=\"success\">File successfully uploaded! Filename is: $path$pic</p>";
				}
				
				print "<form action=\"admin.php\" method=\"post\" enctype=\"multipart/form-data\" class=\"adForm\">";
				print "Location: <select name=\"loc\"><option>Root</option><option>Images/</option><option>Games/</option><option>Util/</option><option>Styles/</option><option>Audio/</option><option>Videos/</option></select><br>";
				print "<input type=\"file\" name=\"upload\"/><br>";
				print "<input type=\"hidden\" name=\"cmd\" value=\"upload\"/>";
				print "<input type=\"submit\" name=\"done\" value=\"Upload\"/>";
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

