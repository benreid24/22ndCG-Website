<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("hqlkiaju_Main", $website);

  $game = $_GET['game'];
	if (!isset($game))
	$game = $_POST['game'];
	if (!isset($game))
	$game = "none";
	
	$curFile = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="Styles/games.css" rel="stylesheet" type="text/css">
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
		  if ($game=="none")
		  {
			  print "<h1 id=\"title\">Games</h1>";
		    print "<p id=\"siteDesc\">Here's where you get to play some sick games. Check the Development Updates page for your favorite games to see if any new updates are here</p>";
		    print "<br><h2>Games:</h2>";
			
			  $query = mysql_query("SELECT * FROM Game ORDER BY Id DESC", $website);
			  while ($data = mysql_fetch_row($query))
			  {
			    print "<div style=\"display: table; margin: 0 auto;\"><div class=\"game\">";
				  print "<img src=\"".$data[2]."\" alt=\"Logo\" class=\"gmLogo\">";
			    print "<a href=\"games.php?game=".$data[3]."\" class=\"gmTitle\"><h2 class=\"gmTitle\">".$data[0]."</h2></a>";
				  print "<p class=\"gmDesc\">".$data[1]."</p>";
				  print "<p class=\"gmTxt\">Development Team: ";
					$tmp = strtok($data[4], ",");
					print "<a href=\"team.php#$tmp\" class=\"gmMembers\">$tmp</a>";
					while ($tmp = strtok(","))
					{
					  $tmp = substr($tmp, 1);
					  print "<a href=\"team.php#$tmp\" class=\"gmMembers\">, $tmp</a>";
					}
					print "</p>";
				  print "</div></div><br><br>";
			  }
			}
			else
			{
				$query = mysql_query("SELECT * FROM Game WHERE Id='$game'", $website);
				$data = mysql_fetch_array($query);
				$link = $_GET['link'];
				if (!$link)
				$link = $_POST['link'];
				if (!$link)
				$link = "none";
				
				if ($link=="none")
				{
				  print "<a href=\"".$data[5]."\" class=\"gmDownload\"><img src=\"".$data[7]."\" alt=\"Download\"></a>";
				  print "<h1 class=\"gmTitle\">".$data[0]."</h1>";
					print "<p class=\"gmDesc\">".$data[1]."</p>";
					print "<p class=\"gmTxt\">Development Team: <span class=\"gmMembers\">";
					$tmp = strtok($data[4], ",");
					print "<a href=\"team.php#$tmp\" class=\"gmMembers\">$tmp</a>";
					while ($tmp = strtok(","))
					{
					  $tmp = substr($tmp, 1);
					  print "<a href=\"team.php#$tmp\" class=\"gmMembers\">, $tmp</a>";
					}
					print "</span></p><br><br><br>";
					print "<!--<div style=\"margin-left: auto; margin-right: auto;\">--><div class=\"gmLinkBx\">";
					print "<br><a href=\"games.php?game=$game&link=dev\" class=\"gmLink\">Development Updates</a><br><br>";
					print "<a href=\"games.php?game=$game&link=for\" class=\"gmLink\">Forums</a><br><br>";
					print "<a href=\"games.php?game=$game&link=rev\" class=\"gmLink\">Reviews</a><br><br>";
					print "<a href=\"games.php?game=$game&link=bug\" class=\"gmLink\">Report Bugs / Make Suggestions</a><br>";
					print "</div><!--</div>--><br><br>";
				}
				else
				{
					if ($link=="for")
					{
					  $query2 = mysql_query("SELECT * FROM Forum WHERE Game='$game'", $website);
					  
						print "<a href=\"games.php?game=$game\" class=\"topLinks\">".$data[0]."</a> -> Forums";
						print "<h1 id=\"title\">Forums</h1>";
		                print "<p id=\"siteDesc\">Talk about the game or get help in here.</p>";
						while ($data2 = mysql_fetch_array($query2))
						{
						  print "<div style=\"display: table; margin: 0 auto;\"><div class=\"gmForum\">";
						  print "<a href=\"forum.php?game=$game&forum=".$data2[0]."\" style=\"text-decoration: none;\"><h2 class=\"gmFrmName\">".$data2[2]."</h2></a>";
							print "<p class=\"gmFrmDesc\">".$data2[3]."</p>";
							print "</div></div><br><br>";
						}
					}
					if ($link=="rev")
					{
					  $query2 = mysql_query("SELECT * FROM Review WHERE Game='$game' ORDER BY Stars", $website);
					
					  print "<p class=\"topLinks\"><a href=\"games.php?game=$game\" class=\"topLinks\">".$data[0]."</a> -> Reviews</p>";
					  print "<h1 id=\"title\">Reviews</h1>";
					  print "<p id=\"siteDesc\">We almost didn't make this section because we knew everyone would love our games.</p>";
						if (mysql_num_rows($query2)==0)
						{
						  print "<p class=\"error\">No reviews yet! If you've played the game, why don't you post one?</p>";
						}
						else
						  print "<h2 style=\"text-align: center; font-weight: bold; text-decoration: underline;\">Player Reviews</h2>";
						
						print "<br>";
						while ($data2 = mysql_fetch_array($query2))
						{
						  print "<div style=\"display: table; margin: 0 auto;\"><div class=\"gmReview\">";
							for ($i = 0; $i<$data2[2]; $i++)
							{
							  print "<img class=\"gmStar\" src=\"Images/star.png\" alt=\"Star\">";
							}
							print "<p class=\"gmRevCont\">".$data2[3]."</p>";
							print "<p><a href=\"account.php?user=".$data2[0]."\" class=\"gmRevPoster\">".$data2[0]."</a>";
							print "<span class=\"gmRevDate\">".$data2[1]."</span></p>";
							print "</div></div>";
						}
						print "<br><br>";
						if ($_SESSION['name'] && $_SESSION['name']!="out")
						{
						  $done = $_POST['done'];
							
							if ($done)
							{
							    $date = $_POST['date'];
								$poster = $_POST['poster'];
								$content = $_POST['cont'];
								$stars = strtok($_POST['rate'], " "); //will yeild number
								
								$content = clean($content);
								$inserted = mysql_query("INSERT INTO Review (Poster, Date, Stars, Content, Game) VALUES('$poster', '$date', '$stars', '$content', '$game')", $website);
									
							  if ($inserted)
								{
									print "<div style=\"display: table; margin: 0 auto;\"><p class=\"success\">Your review has been posted!<br><a href=\"games.php?game=$game&cmd=rev\">Back</a></p></div>";
									print "<meta http-equiv=\"refresh\" content=\"2.5; http://www.22ndcg.com/games.php?game=$game&link=rev\">";
								}
								else
								{
									print "<p class=\"error\" style=\"text-align: center;\">You already posted a review for this game!</p>";
								}
							}
							else
							{
							  $date = date("D M d").", ".date("Y");
							  print "<form action=\"games.php\" method=\"post\" class=\"gmRevForm\">";
								print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
								print "<input type=\"hidden\" name=\"link\" value=\"rev\"/>";
								print "<input type=\"hidden\" name=\"poster\" value=\"".$_SESSION['name']."\"/>";
								print "<input type=\"hidden\" name=\"date\" value=\"$date\"/>";
								print "Rating: <select name=\"rate\"><option>1 Star</option><option>2 Stars</option><option>3 Stars</option><option>4 Stars</option><option>5 Stars</option></select><br>";
								print "Why you chose this rating:<br>";
								print "<textarea name=\"cont\" cols=\"55\" rows=\"15\"></textarea><br>";
								print "<input type=\"submit\" name=\"done\" value=\"Post Review\"/>";
								print "</form>";
							}
						}
						else
						{
						  print "<p><a href=\"login.php?e=Login+to+post+a+review&referer=$curFile\">Login</a> or <a href=\"register.php\">Register</a> to post a review.</p>";
						}
					}
					if ($link=="bug")
					{
					  $done = $_POST['done'];
						
						print "<p class=\"topLinks\"><a href=\"games.php?game=$game\" class=\"topLinks\">".$data[0]."</a> -> Report Bugs / Make Suggestions</p>";
						print "<h1 id=\"title\">Bugs/Suggestions</h1>";
		        print "<p id=\"siteDesc\">Notice something that doesn't look right or have an idea for the inprovement of ".$data[0]."? Let us know with the form below.</p>";
						if ($done)
						{
						  $gameName = $_POST['gmName'];
							$name = $_POST['name'];
							$email = $_POST['email'];
							$issue = $_POST['iss'];
							$info = $_POST['info'];
							
							$to = "feedback@22ndcg.com";
							$headers = "From: admin@22ndcg.com";
							$subject = "$issue for $gameName";
							$message = "$name ($email) has submited a $issue for $gameName.\r\n\r\n\r\n";
							$message .= "Info submited: $info";
							mail($to, $subject, $message, $headers);
							
							print "<div style=\"padding-left: 150px;\"><p class=\"success\">Your $issue has been submited. Thank you for your time.<br><a href=\"games.php?game=$game\">Back</a></p></div>";
						}
						else
						{
						  print "<form action=\"games.php\" method=\"post\" style=\"text-align: center;\">";
							print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
							print "<input type=\"hidden\" name=\"link\" value=\"bug\"/>";
							print "<input type=\"hidden\" name=\"gmName\" value=\"".$data[0]."\"/>";
							print "Name: <input type=\"text\" name=\"name\" required=\"required\" size=\"25\"/><br>";
							print "Email: <input type=\"text\" name=\"email\" required=\"required\" size=\"45\"/><br>";
							print "Issue: <select name=\"iss\"><option>Bug Report</option><option>Suggestion</option></select><br>";
							print "Information:<br><textarea name=\"info\" rows=\"15\" cols=\"50\"></textarea><br>";
							print "<input type=\"submit\" name=\"done\" value=\"Submit\"/>";
							print "</form>";
						}
					}
					if ($link=="dev")
					{
					  $updates = mysql_query("SELECT * FROM DevUpdates WHERE Game='$game' ORDER BY Id DESC", $website);
						
						print "<p class=\"topLinks\"><a href=\"games.php?game=$game\" class=\"topLinks\">".$data[0]."</a> -> Development Updates</p>";
						print "<h1 id=\"title\">Development</h1>";
		        print "<p id=\"siteDesc\">Get the latest development information here.</p>";
						print "<p><span class=\"gmTxt\">Development Status:</span> <span class=\"gmDevStat\">".$data[6]."</span><span class=\"gmNorm\"><a href=\"help.php\">(What's this?)</a></span></p>";
						if (mysql_num_rows($updates)==0)
						{
						  print "<p class=\"error\">There have been no development updates yet.</p>";
						}
						while ($update = mysql_fetch_array($updates))
						{
						  print "<div style=\"display: table; margin: 0 auto;\"><div class=\"gmUpdate\">";
							print "<h2 class=\"gmUpdateTitle\">".$update[1]."</h2>";
							print "<p class=\"gmUpdateCont\">".$update[3]."</p>";
							print "<p><a class=\"gmUpdatePoster\" href=\"team.php#".$update[2]."\">".$update[2]."</a><span class=\"gmUpdateDate\">".$update[4]."</span></p>";
							print "</div></div><br><br>";
						}
					}
				}
			}
		?>
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
