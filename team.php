<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("hqlkiaju_Main", $website);
	
	$curFile = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="Styles/team.css" rel="stylesheet" type="text/css">
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
	  <h1 id="title">The 22nd Century Gaming Team</h1>
		<p id="siteDesc">Meet the nerds who were responsible for those awesome games that you can't stop playing (if you don't like them, just humor us)</p>
		<?php
		  $query = mysql_query("SELECT * FROM Admins ORDER BY Id", $website);
			while ($data = mysql_fetch_row($query))
			{
			  print "<div style=\"padding-left: 150px;\"><div id=\"".$data[0]."\" class=\"tmMember\">";
				print "<div style=\"padding: 5px;\"><div class=\"tmPic\"><br>";
				print "<img src=\"".$data[3]."\" alt=\"My Pic\" width=\"200\" height=\"200\"><br>";
				print "<p class=\"tmPicCap\">".$data[7]."</p>";
				print "</div></div>";
			  print "<a href=\"mailto:".$data[8]."\" style=\"text-decoration: none;\"><h2 class=\"tmName\">".$data[0]."</h2></a>";
				print "<p class=\"tmAka\"> a.k.a. ".$data[5]."</p>";
				print "<p class=\"tmMotto\">".$data[6]."</p>";
				print "<p class=\"tmBio\"><span class=\"tmTxt\">Bio:</span> ".$data[2]."</p>";
				print "<p class=\"tmJob\"><span class=\"tmTxt\">Job:</span> ".$data[4]."</p>";
				print "</div></div><br><br>";
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
