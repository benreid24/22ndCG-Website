<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("127.0.0.1:3306", get_db_username(), get_db_password());
	if (!$website)
		print("Error connecting db!");
	if (!mysql_select_db("hqlkiaju_Main", $website))
		print("Error selecting db: ".mysql_error());
	
  $maxPosts = $_GET['mxpsts'];
  if (!$maxPosts)
	$maxPosts = 5;
	
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
	  <h1 id="title">Welcome to 22nd Century Gaming!</h1>
		<p id="siteDesc">We here at 22nd Century Gaming have one purpose: to make awesome free games that you won't be able to stop playing</p>
		<br><h2>News:</h2>
		<?php
		  $query = mysql_query("SELECT * FROM News ORDER BY Id DESC LIMIT $maxPosts", $website);
			while ($data = mysql_fetch_row($query))
			{
			    print "<div class=\"newsPost\">";
				print "<h2 class=\"newsTitle\">".$data[4]."</h2>";
				print "<p class=\"newsContent\">".$data[3]."</p>";
				print "<a href=\"team.php#".$data[1]."\"><span class=\"newsPoster\">".$data[1]."</span></a>";
				print "<span class=\"newsDate\">".$data[2]."</span>";
				print "</div><br><br>";
			}
			$morePosts = $maxPosts + 5;
			print "<a href=\"index.php?mxpsts=$morePosts\" style=\"text-align: center;\">View older news posts...</a>";
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
