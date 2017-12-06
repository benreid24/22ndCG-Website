<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("h2ndxygv_Main", $website);
	
	$_SERVER['REQUEST_URI'];
	
  $game = $_GET['game'];
	if (!isset($game))
	$game = $_POST['game'];
	if (!isset($game))
	$game = "none";
	
	$forum = $_GET['forum'];
	if (!isset($forum))
	$forum = $_POST['forum'];
	if (!isset($forum))
	Header("Location: http://www.22ndcg.org/games.php?game=$game&link=for");
	
	$thread = $_GET['thrd'];
	if (!isset($thread))
	$thread = $_POST['thrd'];
	if (!isset($thread))
	$thread = "none";
	
	$cmd = $_GET['cmd'];
	if (!isset($cmd))
	$cmd = $_POST['cmd'];
	if (!isset($cmd))
	$cmd = "none";
	
	if ($cmd!="none" && (!$_SESSION['name'] || $_SESSION['name']=="out"))
	Header("Location: http://www.22ndcg.org/login.php?e=You+must+login+to+use+the+forums!&referer=$curFile");
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="Styles/forum.css" rel="stylesheet" type="text/css">
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
		  $gQuery = mysql_query("SELECT * FROM Game WHERE Id='$game'", $website);
			$gData = mysql_fetch_array($gQuery);
			$fQuery = mysql_query("SELECT * FROM Forum WHERE Id='$forum'", $website);
			$fData = mysql_fetch_array($fQuery);
			
			if ($thread!="none")
			{
			  $tQuery = mysql_query("SELECT * FROM Threads WHERE Id='$thread'", $website);
			  $tData = mysql_fetch_array($tQuery);
				
				if ($cmd=="none")
				{
					$query = mysql_query("SELECT * FROM ForumPosts WHERE Thread='$thread' ORDER BY Id", $website);
					
					print "<p class=\"topLinks\"><a href=\"games.php?game=$game\">".$gData[0]."</a> -> <a href=\"games.php?game=$game&link=for\">Forums</a> -> <a href=\"forum.php?game=$game&forum=$forum\">".$fData[2]."</a> -> ".$tData[0]."</p>";
					print "<h1 id=\"title\">".$tData[0]."</h1>";
					
					if (mysql_num_rows($query)==0)
					print "<p class=\"error\">Umm... Its empty?</p>";
					while ($data = mysql_fetch_array($query))
					{
					  print "<div style=\"padding-left: 150px;\"><div class=\"frPost\">";
						print "<a href=\"account.php?user=".$data[2]."\" class=\"frPostPoster\">".$data[2]."</a><br>";
						print "<p class=\"frPostCont\">".$data[3]."</p>";
						print "<span class=\"frPostDate\">".$data[4]."</span><br>";
						if ($_SESSION['name'] && $_SESSION['name']!="out")
						{
						  print "<p>";
							if (!$data[5])
							print "<a href=\"forum.php?game=$game&forum=$forum&thrd=$thread&cmd=rep&data=".$data[0]."\" class=\"frLink\">Report</a> ";
							else
							print "<span class=\"frTxt\">Reported</span> ";
							if ($_SESSION['name']==$data[1] || $_SESSION['admin'])
							print "<a href=\"forum.php?game=$game&forum=$forum&thrd=$thread&cmd=del&data=".$data[0]."\" class=\"frLink\">Delete</a> ";
							if ($_SESSION['name']==$data[1])
							print "<a href=\"forum.php?game=$game&forum=$forum&thrd=$thread&cmd=edit&data=".$data[0]."\" class=\"frLink\">Edit</a> ";
							print "</p>";
						}
						print "</div></div><br><br>";
					}
					if ($_SESSION['name'] && $_SESSION['name']!="out")
					{
					  $date = date("D M d").", ".date("Y");
						$name = $_SESSION['name'];
						print "<h2>Reply</h2>";
					  print "<form action=\"forum.php\" method=\"post\">";
						print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
						print "<input type=\"hidden\" name=\"forum\" value=\"$forum\"/>";
						print "<input type=\"hidden\" name=\"thrd\" value=\"$thread\"/>";
						print "<input type=\"hidden\" name=\"poster\" value=\"$name\"/>";
						print "<input type=\"hidden\" name=\"date\" value=\"$date\"/>";
						print "<input type=\"hidden\" name=\"cmd\" value=\"post\"/>";
						print "Content:<br>";
						print "<textarea name=\"cont\" cols=\"60\" rows=\"20\"></textarea><br>";
						print "<input type=\"submit\" value=\"Post\"/>";
						print "</form>";
					}
				}
				else //$cmd!="none"
				{
				  if ($cmd=="rep")
					{
					  $post = $_GET['data'];
						$post = clean($post);
						mysql_query("UPDATE ForumPosts SET Reported='1' WHERE Id='$post'", $website);
						$query = mysql_query("SELECT * FROM ForumPosts WHERE Id='$post'", $website);
						$data = mysql_fetch_array($query);
						$jerk = mysql_query("SELECT * FROM Users WHERE Username='".$data[1]."'", $website);
						$tmp = mysql_fetch_array($jerk);
						$comps = $tmp[6]+1;
						mysql_query("UPDATE Users SET Complaints='$comps' WHERE Username='".$data[1]."'", $website);
						mail("admin@22ndcg.org", "Forum Post Reported", "A post on this <a href=\"http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$thread\">page</a> has been reported", "From: admin@22ndcg.org\r\nContent-type: text/html;\r\n");
						print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$thread\">";
					}
					if ($cmd=="edit")
					{
					  $done = $_POST['done'];
						$post = $_GET['data'];
						if (!isset($post))
						$post = $_POST['data'];
						
						if ($done)
						{
						  $cont = $_POST['cont'];
							$cont = clean($cont);
							$post = clean($post);
							mysql_query("UPDATE ForumPosts SET Content='$cont' WHERE Id='$post'", $website);
							print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$thread\">";
						}
						else
						{
						  $query = mysql_query("SELECT * FROM ForumPosts WHERE Id='$post'", $website);
							$data = mysql_fetch_array($query);
						
						  print "<p class=\"topLinks\"><a href=\"games.php?game=$game\">".$gData[0]."</a> -> <a href=\"games.php?game=$game&link=for\">Forums</a> -> <a href=\"forum.php?game=$game&forum=$forum\">".$fData[2]."</a> -> <a href=\"forum.php?game=$game&forum=$forum&thrd=$thread\">".$tData[0]."</a> -> Edit Post</p>";
							print "<h1 id=\"title\">Edit Post</h1>";
							
							print "<form action=\"forum.php\" method=\"post\" class=\"frForm\">";
							print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
							print "<input type=\"hidden\" name=\"forum\" value=\"$forum\"/>";
							print "<input type=\"hidden\" name=\"thrd\" value=\"$thread\"/>";
							print "<input type=\"hidden\" name=\"cmd\" value=\"edit\"/>";
							print "<input type=\"hidden\" name=\"data\" value=\"$post\"/>";
							print "Content:<br>";
							print "<textarea name=\"cont\" cols=\"60\" rows=\"20\">".$data[2]."</textarea><br>";
							print "<input type=\"submit\" value=\"Save\" name=\"done\"/>";
							print "</form>";
						}
					}
					if ($cmd=="del")
					{
					  $post = $_GET['data'];
						$post = clean($post);
						mysql_query("DELETE FROM ForumPosts WHERE Id='$post'", $website);
						print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$thread\">";
					}
					if ($cmd=="post")
					{
					  $content = $_POST['cont'];
						$poster = $_POST['poster'];
						$date = $_POST['date'];
						$content = clean($content);
						$poster = clean($poster);
						$date = clean($date);
						mysql_query("INSERT INTO ForumPosts (Thread, Poster, Content, Date) VALUES('$thread', '$poster', '$content', '$date')", $website);
						print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$thread\">";
					}
				}
			}
			else
			{
			  if ($cmd=="none")
			  {
				  //print all threads in forum
					$query = mysql_query("SELECT * FROM Threads WHERE Forum='$forum' ORDER BY Id DESC", $website);
				
					print "<p class=\"topLinks\"><a href=\"games.php?game=$game\">".$gData[0]."</a> -> <a href=\"games.php?game=$game&link=for\">Forums</a> -> ".$fData[2]."</p>";
					print "<h1 id=\"title\">".$fData[2]."</h1>";
					print "<p id=\"siteDesc\">".$fData[3]."</p>";
					if (mysql_num_rows($query)==0)
					{
				    print "<p class=\"error\">There are no threads yet!</p>";
						if (!$_SESSION['name'] || $_SESSION['name']=="out")
						print "<p style=\"text-align: center;\"><a href=\"login.php?e=Login+to+create+threads&referer=$curFile\">Login</a> or <a href=\"register.php\">Register</a> to create threads.</p>";
						else
						print "<a href=\"forum.php?game=$game&forum=$forum&cmd=pthrd\" style=\"text-align: center;\">Create one</a>";
				  }
					else
					{
				    if ($_SESSION['name'] && $_SESSION['name']!="out")
				  	print "<a href=\"forum.php?game=$game&forum=$forum&cmd=pthrd\" class=\"frLink\">Create Thread</a><br><br>";
						while ($data = mysql_fetch_array($query))
						{
					    print "<div style=\"padding-left: 200px;\"><div class=\"frThread\">";
							print "<a href=\"forum.php?game=$game&forum=$forum&thrd=".$data[3]."\" class=\"frThrdTitle\"><h2 class=\"frThrdTitle\">".$data[0]."</h2></a>";
							print "<p><a href=\"account.php?user=".$data[2]."\" class=\"frThrdPoster\">".$data[2]."</a></span><span class=\"frThrdDate\">".$data[1]."</span></p>";
							print "<p>";
							if ($_SESSION['name'] && $_SESSION['name']!="out")
							{
							  if (!$data[5])
							  print "<a href=\"forum.php?game=$game&forum=$forum&cmd=rep&data=".$data[3]."\" class=\"frLink\">Report</a> ";
							  else
								print "<span class=\"frTxt\">Reported</span>";
							}
							if ($_SESSION['name']==$data[2] || $_SESSION['admin'])
							{
							  print "<a href=\"forum.php?game=$game&forum=$forum&cmd=del&data=".$data[3]."\" class=\"frLink\">Delete</a> ";
								if ($_SESSION['name']==$data[2])
								print "<a href=\"forum.php?game=$game&forum=$forum&cmd=edit&data=".$data[3]."\" class=\"frLink\">Edit</a>";
							}
							print "</p></div></div><br><br>";
						}
					}
				}
				else //$cmd!="none"
				{
					if ($cmd=="pthrd")
					{
						$done = $_POST['done'];
						
						print "<p class=\"topLinks\"><a href=\"games.php?game=$game\">".$gData[0]."</a> -> <a href=\"games.php?game=$game&link=for\">Forums</a> -> <a href=\"forum.php?game=$game&forum=$forum\">".$fData[2]."</a> -> Create Thread</p>";
						print "<h1 id=\"title\">Create Thread</h1>";
						print "<p id=\"siteDesc\">Create a new thread here.</p>";
						
						if ($done)
						{
						  $date = $_POST['date'];
							$poster = $_POST['poster'];
							$title = $_POST['title'];
							$date = clean($date);
							$poster = clean($poster);
							$title = clean($title);
							mysql_query("INSERT INTO Threads (Name, Date, Poster, Forum) VALUES('$title', '$date', '$poster', '$forum')", $website);
							$query = mysql_query("SELECT * FROM Threads WHERE Name='$title'", $website);
							$data = mysql_fetch_array($query);
							$id = $data[3];
							print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$id\">";
						}
						else
						{
						  $date = date("D M d").", ".date("Y");
						  print "<form action=\"forum.php\" method=\"post\" class=\"frForm\">";
							print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
							print "<input type=\"hidden\" name=\"forum\" value=\"$forum\"/>";
							print "<input type=\"hidden\" name=\"cmd\" value=\"pthrd\"/>";
							print "<input type=\"hidden\" name=\"date\" value=\"$date\"/>";
							print "<input type=\"hidden\" name=\"poster\" value=\"".$_SESSION['name']."\"/>";
							print "Title: <input type=\"text\" name=\"title\" size=\"60\" required=\"required\"/><br>";
							print "<input type=\"submit\" name=\"done\" value=\"Create\"/>";
							print "</form>";
						}
					}
					if ($cmd=="rep")
					{
					  $thrd = $_GET['data'];
						$thrd = clean($thrd);
						$query = mysql_query("SELECT * FROM Threads WHERE Id='$thrd'", $website);
						$data = mysql_fetch_array($query);
						$poster = $data[2];
						$jerk = mysql_fetch_array(mysql_query("SELECT * FROM Users WHERE Username='$poster'", $website));
						$comps = $jerk[6];
						$comps++;
						
						mysql_query("UPDATE Users SET Complaints='$comps' WHERE Username='$poster'", $website);
						mysql_query("UPDATE Threads SET Reported='1' WHERE Id='$thrd'", $website);
						
						mail("admin@22ndcg.org", "Forum Thread Reported", "A thread on this <a href=\"http://www.22ndcg.org/forum.php?game=$game&forum=$forum&thrd=$thrd\">page</a> has been reported", "From: admin@22ndcg.org\r\nContent-type: text/html;\r\n");
						
						print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum\">";
					}
					if ($cmd=="del")
					{
					  $thrd = $_GET['data'];
						$thrd = clean($thrd);
						mysql_query("DELETE FROM ForumPosts WHERE Thread='$thrd'", $website);
						mysql_query("DELETE FROM Threads WHERE Id='$thrd'", $website);
						print "<meta http-equiv=\"refresh\" content=\"0;http://www.22ndcg.org/forum.php?game=$game&forum=$forum\">";
					}
					if ($cmd=="edit")
					{
					  $done = $_POST['done'];
						$thrd = $_GET['data'];
						$thrd = clean($thrd);
						if (!$thrd)
						  $thrd = $_POST['data'];
						print "<p class=\"topLinks\"><a href=\"games.php?game=$game\">".$gData[0]."</a> -> <a href=\"games.php?game=$game&link=for\">Forums</a> -> <a href=\"forum.php?game=$game&forum=$forum\">".$fData[2]."</a> -> Edit Thread</p>";
						print "<h1 id=\"title\">Edit Thread</h1>";
						print "<p id=\"siteDesc\">Change the name of the thread you made.</p>";
						
						if ($done)
						{
						  $title = $_POST['title'];
							$title = clean($title);
							mysql_query("UPDATE Threads SET Name='$title' WHERE Id='$thrd'", $website);
							print "<div style=\"padding-left: 150px;\"><p class=\"success\">Saved</p></div>";
							print "<meta http-equiv=\"refresh\" content=\"2;http://www.22ndcg.org/forum.php?game=$game&forum=$forum\">";
						}
						else
						{
						  print "<form action=\"forum.php\" method=\"post\" class=\"frForm\">";
							print "<input type=\"hidden\" name=\"game\" value=\"$game\"/>";
							print "<input type=\"hidden\" name=\"forum\" value=\"$forum\"/>";
							print "<input type=\"hidden\" name=\"cmd\" value=\"edit\"/>";
							print "<input type=\"hidden\" name=\"data\" value=\"$thrd\"/>";
							print "Title: <input type=\"text\" size=\"60\" name=\"title\"/><br>";
							print "<input type=\"submit\" name=\"done\" value=\"Save\"/>";
							print "</form>";
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
